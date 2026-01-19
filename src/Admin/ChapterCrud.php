<?php
namespace StoryMgr\Admin;

use StoryMgr\Support\Seo;
use StoryMgr\Features\Cache;

final class ChapterCrud {
    private static function getStoryPost(int $storyId) {
        $p = get_post($storyId);
        if (!$p || $p->post_type !== 'post') return null;
        return $p;
    }

    public static function handleSaveChapter(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
        if (!wp_verify_nonce($nonce, 'storymgr_save_chapter')) {
            wp_die(esc_html__('Invalid nonce', 'storymgr'));
        }

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $storyId = isset($_POST['story_id']) ? absint($_POST['story_id']) : 0;
        $title   = isset($_POST['title']) ? sanitize_text_field(wp_unslash($_POST['title'])) : '';
        $content = isset($_POST['content']) ? wp_kses_post(wp_unslash($_POST['content'])) : '';
        $status  = isset($_POST['status']) ? absint($_POST['status']) : 0;

        $seoTitleIn = isset($_POST['seo_title']) ? sanitize_text_field(wp_unslash($_POST['seo_title'])) : '';
        $seoDescIn  = isset($_POST['seo_description']) ? sanitize_textarea_field(wp_unslash($_POST['seo_description'])) : '';

        if ($storyId <= 0 || $title === '') {
            wp_die(esc_html__('Missing required fields', 'storymgr'));
        }

        $storyPost = self::getStoryPost($storyId);
        if (!$storyPost) {
            wp_die(esc_html__('Invalid story', 'storymgr'));
        }

        $now     = current_time('mysql');
        $userId  = get_current_user_id();
        $wordCount = (int) str_word_count(wp_strip_all_tags($content));

        $wpdb->query('START TRANSACTION');

        try {
            $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$table} WHERE story_id=%d ORDER BY id DESC LIMIT 1 FOR UPDATE",
                $storyId
            ));

            $maxNo = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT MAX(chapter_number) FROM {$table} WHERE story_id=%d",
                $storyId
            ));
            $chapterNumber = $maxNo + 1;

            $slug = sanitize_title('chuong-' . $chapterNumber);

            $publishedAt = ($status === 1) ? $now : null;

            $seoTitle = ($seoTitleIn !== '')
                ? mb_substr($seoTitleIn, 0, 255)
                : Seo::makeTitle(get_the_title($storyId), $chapterNumber, $title);

            $seoDescription = ($seoDescIn !== '')
                ? mb_substr(trim($seoDescIn), 0, 255)
                : Seo::makeDescriptionFromContent($content, 160);

            $ok = $wpdb->insert(
                $table,
                [
                    'story_id'        => $storyId,
                    'chapter_number'  => $chapterNumber,
                    'title'           => $title,
                    'slug'            => $slug,
                    'content'         => $content,
                    'status'          => $status ? 1 : 0,
                    'word_count'      => $wordCount,
                    'published_at'    => $publishedAt,
                    'created_by'      => $userId ?: null,
                    'updated_by'      => $userId ?: null,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                    'seo_title'       => $seoTitle,
                    'seo_description' => $seoDescription,
                ],
                [
                    '%d','%d','%s','%s','%s','%d','%d','%s','%d','%d','%s','%s','%s','%s'
                ]
            );

            if ($ok === false) {
                throw new \Exception('DB insert failed');
            }

            $wpdb->query('COMMIT');
        } catch (\Throwable $e) {
            $wpdb->query('ROLLBACK');
            wp_die(esc_html__('DB insert failed (maybe duplicate chapter number).', 'storymgr'));
        }

        Cache::rebuildStoryCache($storyId);

        wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&saved=1'));
        exit;
    }

    public static function handleUpdateChapter(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $chapterId = isset($_POST['chapter_id']) ? absint($_POST['chapter_id']) : 0;
        if ($chapterId <= 0) wp_die(esc_html__('Invalid chapter_id', 'storymgr'));

        $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
        if (!wp_verify_nonce($nonce, 'storymgr_update_chapter_' . $chapterId)) {
            wp_die(esc_html__('Invalid nonce', 'storymgr'));
        }

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $chapterId), ARRAY_A);
        if (!$row) wp_die(esc_html__('Chapter not found', 'storymgr'));

        $storyId       = (int) $row['story_id'];
        $chapterNumber = (int) $row['chapter_number'];

        if (!self::getStoryPost($storyId)) {
            wp_die(esc_html__('Invalid story', 'storymgr'));
        }

        $title   = isset($_POST['title']) ? sanitize_text_field(wp_unslash($_POST['title'])) : '';
        $content = isset($_POST['content']) ? wp_kses_post(wp_unslash($_POST['content'])) : '';
        $status  = isset($_POST['status']) ? absint($_POST['status']) : 0;

        $seoTitleIn = isset($_POST['seo_title']) ? sanitize_text_field(wp_unslash($_POST['seo_title'])) : '';
        $seoDescIn  = isset($_POST['seo_description']) ? sanitize_textarea_field(wp_unslash($_POST['seo_description'])) : '';

        if ($title === '') {
            wp_die(esc_html__('Missing required fields', 'storymgr'));
        }

        $now     = current_time('mysql');
        $userId  = get_current_user_id();
        $wordCount = (int) str_word_count(wp_strip_all_tags($content));

        $newStatus = $status ? 1 : 0;

        $publishedAt = !empty($row['published_at']) ? (string) $row['published_at'] : null;
        if ($newStatus === 1 && empty($publishedAt)) {
            $publishedAt = $now;
        }

        $slug = !empty($row['slug'])
            ? (string) $row['slug']
            : sanitize_title('chuong-' . $chapterNumber);

        $seoTitle = ($seoTitleIn !== '')
            ? mb_substr($seoTitleIn, 0, 255)
            : Seo::makeTitle(get_the_title($storyId), $chapterNumber, $title);

        $seoDescription = ($seoDescIn !== '')
            ? mb_substr(trim($seoDescIn), 0, 255)
            : Seo::makeDescriptionFromContent($content, 160);

        $ok = $wpdb->update(
            $table,
            [
                'title'           => $title,
                'slug'            => $slug,
                'content'         => $content,
                'status'          => $newStatus,
                'word_count'      => $wordCount,
                'published_at'    => $publishedAt,
                'updated_by'      => $userId ?: null,
                'updated_at'      => $now,
                'seo_title'       => $seoTitle,
                'seo_description' => $seoDescription,
            ],
            ['id' => $chapterId],
            ['%s','%s','%s','%d','%d','%s','%d','%s','%s','%s'],
            ['%d']
        );

        if ($ok === false) wp_die(esc_html__('DB update failed', 'storymgr'));

        Cache::rebuildStoryCache($storyId);

        wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&updated=1'));
        exit;
    }

    public static function handleDeleteChapter(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $chapterId = isset($_GET['chapter_id']) ? absint($_GET['chapter_id']) : 0;
        $nonce     = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

        if ($chapterId <= 0 || !wp_verify_nonce($nonce, 'storymgr_delete_chapter_' . $chapterId)) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $storyId = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT story_id FROM {$table} WHERE id = %d",
            $chapterId
        ));

        $ok = $wpdb->delete($table, ['id' => $chapterId], ['%d']);
        if ($ok === false) wp_die(esc_html__('DB delete failed', 'storymgr'));

        if ($storyId > 0) {
            Cache::rebuildStoryCache($storyId);
        }

        wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&deleted=1'));
        exit;
    }
}
