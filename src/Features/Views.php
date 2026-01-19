<?php
namespace StoryMgr\Features;

use StoryMgr\Frontend\Frontend;

final class Views {
    public static function tableChapterViews(): string {
        global $wpdb;
        return $wpdb->prefix . 'story_chapter_views';
    }

    public static function viewQueueOption(): string {
        return 'storymgr_view_queue';
    }

    public static function viewBufferKey(int $chapterId): string {
        return 'storymgr_viewbuf_' . $chapterId;
    }

    public static function bufferChapterView(int $storyId, int $chapterId, int $by = 1): bool {
        $by = max(1, $by);
        if ($storyId <= 0 || $chapterId <= 0) return false;

        $key = self::viewBufferKey($chapterId);
        $payload = get_transient($key);

        if (!is_array($payload)) {
            $payload = [
                'story_id' => $storyId,
                'count'    => 0,
            ];
        }

        $payload['story_id'] = $storyId;
        $payload['count'] = (int) $payload['count'] + $by;

        set_transient($key, $payload, 10 * MINUTE_IN_SECONDS);

        $opt = self::viewQueueOption();
        $queue = get_option($opt);
        if ($queue === false) {
            add_option($opt, [$chapterId], '', 'no');
        } else {
            if (!is_array($queue)) {
                $queue = [];
            }
            if (!in_array($chapterId, $queue, true)) {
                $queue[] = $chapterId;
                update_option($opt, $queue);
            }
        }

        return true;
    }

    public static function getChapterViewCount(int $chapterId): int {
        global $wpdb;

        if ($chapterId <= 0) return 0;

        $table = self::tableChapterViews();
        return (int) $wpdb->get_var($wpdb->prepare(
            "SELECT total_views FROM {$table} WHERE chapter_id = %d",
            $chapterId
        ));
    }

    public static function getChapterViewCountWithBuffer(int $chapterId): int {
        if ($chapterId <= 0) return 0;

        $total = self::getChapterViewCount($chapterId);
        $payload = get_transient(self::viewBufferKey($chapterId));
        if (is_array($payload) && !empty($payload['count'])) {
            $total += (int) $payload['count'];
        }

        return $total;
    }

    public static function getStoryTotalViews(int $storyId, bool $includeBuffer = true): int {
        global $wpdb;

        if ($storyId <= 0) return 0;

        $cacheTable = $wpdb->prefix . 'story_cache';
        $total = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT total_views FROM {$cacheTable} WHERE story_id = %d",
            $storyId
        ));

        if (!$includeBuffer) {
            return $total;
        }

        $queue = get_option(self::viewQueueOption());
        if (!is_array($queue) || empty($queue)) {
            return $total;
        }

        foreach ($queue as $chapterId) {
            $payload = get_transient(self::viewBufferKey((int) $chapterId));
            if (!is_array($payload) || empty($payload['count']) || empty($payload['story_id'])) {
                continue;
            }
            if ((int) $payload['story_id'] === $storyId) {
                $total += (int) $payload['count'];
            }
        }

        return $total;
    }

    public static function flushChapterViews(): void {
        global $wpdb;

        $opt = self::viewQueueOption();
        $queue = get_option($opt);
        if (!is_array($queue) || empty($queue)) return;

        $table = self::tableChapterViews();
        $now   = current_time('mysql');
        $nextQueue = [];

        foreach ($queue as $chapterId) {
            $chapterId = (int) $chapterId;
            if ($chapterId <= 0) continue;

            $payload = get_transient(self::viewBufferKey($chapterId));
            if (!is_array($payload) || empty($payload['count'])) {
                delete_transient(self::viewBufferKey($chapterId));
                continue;
            }

            $storyId = !empty($payload['story_id']) ? (int) $payload['story_id'] : 0;
            $count   = (int) $payload['count'];
            if ($storyId <= 0 || $count <= 0) {
                delete_transient(self::viewBufferKey($chapterId));
                continue;
            }

            $wpdb->query($wpdb->prepare(
                "INSERT INTO {$table} (chapter_id, story_id, total_views, updated_at)
                 VALUES (%d, %d, %d, %s)
                 ON DUPLICATE KEY UPDATE total_views = total_views + %d, updated_at = VALUES(updated_at)",
                $chapterId, $storyId, $count, $now, $count
            ));

            Cache::incrementStoryView($storyId, $count);

            delete_transient(self::viewBufferKey($chapterId));
        }

        update_option($opt, $nextQueue);
    }

    public static function registerViewCron(array $schedules): array {
        if (!isset($schedules['storymgr_five_minutes'])) {
            $schedules['storymgr_five_minutes'] = [
                'interval' => 5 * MINUTE_IN_SECONDS,
                'display'  => __('Every 5 Minutes', 'storymgr'),
            ];
        }
        return $schedules;
    }

    public static function scheduleViewFlush(): void {
        if (!wp_next_scheduled('storymgr_flush_chapter_views')) {
            wp_schedule_event(time(), 'storymgr_five_minutes', 'storymgr_flush_chapter_views');
        }
    }

    public static function clearViewFlush(): void {
        $timestamp = wp_next_scheduled('storymgr_flush_chapter_views');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'storymgr_flush_chapter_views');
        }
    }

    public static function trackChapterView(int $storyId, int $chapterId): void {
        if ($storyId <= 0 || $chapterId <= 0) return;

        $cookieKey = 'storymgr_viewed_' . $chapterId;
        if (!empty($_COOKIE[$cookieKey])) {
            return;
        }

        self::bufferChapterView($storyId, $chapterId, 1);

        if (!headers_sent()) {
            setcookie($cookieKey, '1', time() + 5 * MINUTE_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN);
        }
    }

    public static function handleChapterView(array $chapter, \WP_Post $story): void {
        if (did_action('storymgr_chapter_view_tracked')) return;
        do_action('storymgr_chapter_view_tracked');

        $chapterId = !empty($chapter['id']) ? (int) $chapter['id'] : 0;
        $storyId   = (int) $story->ID;
        if ($chapterId <= 0 || $storyId <= 0) return;

        self::trackChapterView($storyId, $chapterId);

        if (is_user_logged_in()) {
            $chapterNumber = !empty($chapter['chapter_number']) ? (int) $chapter['chapter_number'] : null;
            Progress::setUserStoryProgress(get_current_user_id(), $storyId, $chapterId, $chapterNumber, 0.00);
        }
    }

    public static function appendViewMeta(string $content): string {
        if (is_admin()) return $content;

        if (Frontend::isChapterQuery()) {
            $data = Frontend::getCurrentChapterData();
            if ($data && !empty($data['chapter']['id'])) {
                $views = self::getChapterViewCountWithBuffer((int) $data['chapter']['id']);
                $meta = '<div class="storymgr-view-meta storymgr-view-meta-chapter">' .
                    esc_html(sprintf(__('Views: %d', 'storymgr'), $views)) .
                    '</div>';
                return $content . $meta;
            }
        }

        if (is_singular('post')) {
            $storyId = get_the_ID();
            $views = self::getStoryTotalViews($storyId, true);
            $meta = '<div class="storymgr-view-meta storymgr-view-meta-story">' .
                esc_html(sprintf(__('Views: %d', 'storymgr'), $views)) .
                '</div>';
            return $content . $meta;
        }

        return $content;
    }
}
