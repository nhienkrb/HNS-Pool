<?php
namespace StoryMgr\Features;

final class Cache {
    public static function tableChapters(): string {
        global $wpdb;
        return $wpdb->prefix . 'story_chapters';
    }

    public static function tableCache(): string {
        global $wpdb;
        return $wpdb->prefix . 'story_cache';
    }

    public static function rebuildStoryCache(int $storyId): bool {
        global $wpdb;

        if ($storyId <= 0) return false;

        $chapters = self::tableChapters();
        $cache    = self::tableCache();

        $total = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$chapters} WHERE story_id = %d",
            $storyId
        ));

        $last = $wpdb->get_row($wpdb->prepare(
            "SELECT id, chapter_number, created_at
             FROM {$chapters}
             WHERE story_id = %d AND status = 1
             ORDER BY chapter_number DESC
             LIMIT 1",
            $storyId
        ), ARRAY_A);

        $lastId  = $last ? (int) $last['id'] : null;
        $lastNo  = $last ? (int) $last['chapter_number'] : null;
        $lastAt  = $last ? $last['created_at'] : null;

        $views = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT total_views FROM {$cache} WHERE story_id = %d",
            $storyId
        ));

        $now = current_time('mysql');

        $ok = $wpdb->replace(
            $cache,
            [
                'story_id'           => $storyId,
                'total_chapters'     => $total,
                'total_views'        => $views,
                'last_chapter_id'    => $lastId,
                'last_chapter_number'=> $lastNo,
                'last_chapter_at'    => $lastAt,
                'updated_at'         => $now,
            ],
            ['%d','%d','%d','%d','%d','%s','%s']
        );

        return ($ok !== false);
    }

    public static function rebuildAllCache(): int {
        global $wpdb;

        $chapters = self::tableChapters();
        $storyIds = $wpdb->get_col("SELECT DISTINCT story_id FROM {$chapters}");

        if (empty($storyIds)) return 0;

        $count = 0;
        foreach ($storyIds as $sid) {
            if (self::rebuildStoryCache((int) $sid)) $count++;
        }
        return $count;
    }

    public static function incrementStoryView(int $storyId, int $by = 1) {
        global $wpdb;

        $by = max(1, $by);
        if ($storyId <= 0) return false;

        $cache = self::tableCache();
        $now   = current_time('mysql');

        $wpdb->query($wpdb->prepare(
            "INSERT INTO {$cache} (story_id, total_chapters, total_views, last_chapter_at, updated_at)
             VALUES (%d, 0, 0, NULL, %s)
             ON DUPLICATE KEY UPDATE updated_at = VALUES(updated_at)",
            $storyId, $now
        ));

        return $wpdb->query($wpdb->prepare(
            "UPDATE {$cache} SET total_views = total_views + %d, updated_at = %s WHERE story_id = %d",
            $by, $now, $storyId
        ));
    }

    public static function handleRebuildStoryCache(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $storyId = isset($_GET['story_id']) ? absint($_GET['story_id']) : 0;
        $nonce   = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

        if ($storyId <= 0 || !wp_verify_nonce($nonce, 'storymgr_rebuild_cache_' . $storyId)) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        self::rebuildStoryCache($storyId);
        wp_safe_redirect(admin_url('admin.php?page=storymgr-cache&rebuilt=1'));
        exit;
    }

    public static function handleRebuildAllCache(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
        if (!wp_verify_nonce($nonce, 'storymgr_rebuild_all_cache')) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        $count = self::rebuildAllCache();
        wp_safe_redirect(admin_url('admin.php?page=storymgr-cache&rebuilt_all=' . (int) $count));
        exit;
    }
}
