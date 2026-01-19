<?php
namespace StoryMgr\Features;

use StoryMgr\Plugin;
use StoryMgr\Frontend\Frontend;

final class Progress {
    public static function tableProgress(): string {
        global $wpdb;
        return $wpdb->prefix . 'user_story_progress';
    }

    public static function setUserStoryProgress(
        int $userId,
        int $storyId,
        ?int $chapterId,
        ?int $chapterNumber = null,
        float $progressPercent = 0.00
    ) {
        global $wpdb;

        $chapterId = $chapterId ? (int) $chapterId : null;
        $chapterNumber = $chapterNumber ? (int) $chapterNumber : null;
        $progressPercent = max(0, $progressPercent);

        if ($userId <= 0 || $storyId <= 0) return false;

        $table = self::tableProgress();
        $now   = current_time('mysql');

        $sql = $wpdb->prepare(
            "INSERT INTO {$table} (user_id, story_id, chapter_id, chapter_number, progress_percent, last_read_at, updated_at)
             VALUES (%d, %d, %s, %s, %f, %s, %s)
             ON DUPLICATE KEY UPDATE
                chapter_id = VALUES(chapter_id),
                chapter_number = VALUES(chapter_number),
                progress_percent = VALUES(progress_percent),
                last_read_at = VALUES(last_read_at),
                updated_at = VALUES(updated_at)",
            $userId, $storyId, $chapterId, $chapterNumber, $progressPercent, $now, $now
        );

        return $wpdb->query($sql);
    }

    public static function getUserProgressMap(int $userId): array {
        global $wpdb;

        if ($userId <= 0) return [];

        $table = self::tableProgress();
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT story_id, chapter_id, chapter_number, last_read_at, progress_percent
             FROM {$table}
             WHERE user_id = %d",
            $userId
        ), ARRAY_A);

        $map = [];
        foreach ($rows as $row) {
            $sid = (int) $row['story_id'];
            $map[$sid] = [
                'chapter_id' => !empty($row['chapter_id']) ? (int) $row['chapter_id'] : null,
                'chapter_number' => !empty($row['chapter_number']) ? (int) $row['chapter_number'] : null,
                'last_read_at' => (string) $row['last_read_at'],
                'progress_percent' => isset($row['progress_percent']) ? (float) $row['progress_percent'] : 0.0,
            ];
        }

        return $map;
    }

    public static function handleDeleteProgress(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $id    = isset($_GET['id']) ? absint($_GET['id']) : 0;
        $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

        if ($id <= 0 || !wp_verify_nonce($nonce, 'storymgr_delete_progress_' . $id)) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        global $wpdb;
        $table = self::tableProgress();

        $wpdb->delete($table, ['id' => $id], ['%d']);

        wp_safe_redirect(admin_url('admin.php?page=storymgr-progress&deleted=1'));
        exit;
    }

    public static function enqueueReadingProgressScript(): void {
        if (is_admin()) return;
        if (!Frontend::isChapterQuery()) return;

        $data = Frontend::getCurrentChapterData();
        if (!$data || empty($data['chapter']['id']) || empty($data['story']->ID)) return;

        $chapterId = (int) $data['chapter']['id'];
        $storyId   = (int) $data['story']->ID;
        if ($chapterId <= 0 || $storyId <= 0) return;

        $handle = 'storymgr-reading-progress';
        $src = Plugin::url('assets/js/reading-progress.js');
        wp_enqueue_script($handle, $src, [], Plugin::version(), true);
        wp_localize_script($handle, 'storymgrProgress', [
            'ajaxUrl'   => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('storymgr_update_progress'),
            'chapterId' => $chapterId,
            'storyId'   => $storyId,
        ]);
    }

    public static function handleUpdateProgressAjax(): void {
        if (!check_ajax_referer('storymgr_update_progress', 'nonce', false)) {
            wp_send_json_error(['message' => 'invalid_nonce']);
        }

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'not_logged_in']);
        }

        $chapterId = isset($_POST['chapter_id']) ? absint($_POST['chapter_id']) : 0;
        $percent   = isset($_POST['percent']) ? (float) wp_unslash($_POST['percent']) : 0.0;

        if ($chapterId <= 0) {
            wp_send_json_error(['message' => 'invalid_chapter']);
        }

        $percent = max(0, min(100, $percent));

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';
        $row = $wpdb->get_row($wpdb->prepare(
            "SELECT id, story_id, chapter_number FROM {$table} WHERE id = %d",
            $chapterId
        ), ARRAY_A);

        if (!$row) {
            wp_send_json_error(['message' => 'chapter_not_found']);
        }

        $storyId = (int) $row['story_id'];
        $chapterNumber = !empty($row['chapter_number']) ? (int) $row['chapter_number'] : null;

        $ok = self::setUserStoryProgress(get_current_user_id(), $storyId, $chapterId, $chapterNumber, $percent);
        if ($ok === false) {
            wp_send_json_error(['message' => 'db_error']);
        }

        wp_send_json_success(['percent' => $percent]);
    }
}
