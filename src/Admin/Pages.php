<?php
namespace StoryMgr\Admin;

use StoryMgr\Admin\ListTable\ChapterListTable;
use StoryMgr\Admin\ListTable\ProgressListTable;
use StoryMgr\Admin\ListTable\CacheListTable;
use StoryMgr\Admin\ListTable\FavoritesListTable;

final class Pages {
    public static function renderDashboard(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Story Manager', 'storymgr') . '</h1>';
        echo '</div>';
    }

    public static function renderChaptersPage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $table = new ChapterListTable();
        $table->process_bulk_action();
        $table->prepare_items();

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Chapters', 'storymgr') . '</h1>';
        if (isset($_GET['saved']))   echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter saved.', 'storymgr') . '</p></div>';
        if (isset($_GET['updated'])) echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter updated.', 'storymgr') . '</p></div>';
        if (isset($_GET['deleted'])) echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter deleted.', 'storymgr') . '</p></div>';
        if (isset($_GET['deleted_count'])) echo '<div class="notice notice-success is-dismissible"><p>' . sprintf(esc_html__('Deleted %d chapters.', 'storymgr'), absint($_GET['deleted_count'])) . '</p></div>';

        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;
        $status  = isset($_REQUEST['status']) ? sanitize_text_field(wp_unslash($_REQUEST['status'])) : '';

        $stories = get_posts([
            'post_type'      => 'post',
            'post_status'    => ['publish','draft'],
            'posts_per_page' => 200,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ]);

        echo '<div style="margin:12px 0; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">';

        echo '<form method="get" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">';
        echo '<input type="hidden" name="page" value="storymgr-chapters" />';

        echo '<select name="story_id">';
        echo '<option value="0">' . esc_html__('All stories', 'storymgr') . '</option>';
        foreach ($stories as $s) {
            $t = $s->post_title ? $s->post_title : ('#' . $s->ID);
            echo '<option value="' . esc_attr($s->ID) . '" ' . selected($storyId, (int) $s->ID, false) . '>' . esc_html($t) . '</option>';
        }
        echo '</select>';

        echo '<select name="status">';
        echo '<option value="">' . esc_html__('All statuses', 'storymgr') . '</option>';
        echo '<option value="published" ' . selected($status, 'published', false) . '>' . esc_html__('Published', 'storymgr') . '</option>';
        echo '<option value="draft" ' . selected($status, 'draft', false) . '>' . esc_html__('Draft', 'storymgr') . '</option>';
        echo '</select>';

        submit_button(__('Filter', 'storymgr'), 'secondary', '', false);
        echo '</form>';

        $addUrl = admin_url('admin.php?page=storymgr-add-chapter');
        if ($storyId > 0) {
            $addUrl = add_query_arg(['story_id' => $storyId], $addUrl);
        }
        echo '<a class="button button-primary" href="' . esc_url($addUrl) . '">' . esc_html__('Add Chapter', 'storymgr') . '</a>';

        echo '</div>';

        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="storymgr-chapters" />';
        echo '<input type="hidden" name="story_id" value="' . esc_attr($storyId) . '" />';
        echo '<input type="hidden" name="status" value="' . esc_attr($status) . '" />';

        wp_nonce_field('storymgr_bulk_chapters');
        $table->search_box(__('Search title', 'storymgr'), 'storymgr-chapters');
        $table->display();

        echo '</form>';
        echo '</div>';
    }

    public static function renderAddChapterPage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $chapterId = isset($_GET['chapter_id']) ? absint($_GET['chapter_id']) : 0;
        $isEdit = $chapterId > 0;

        $row = null;
        if ($isEdit) {
            $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $chapterId), ARRAY_A);
            if (!$row) wp_die(esc_html__('Chapter not found', 'storymgr'));
        }

        $prefillStoryId = isset($_GET['story_id']) ? absint($_GET['story_id']) : 0;

        $stories = get_posts([
            'post_type'      => 'post',
            'post_status'    => ['publish','draft'],
            'posts_per_page' => 200,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ]);

        $vStoryId = $isEdit ? (int) $row['story_id'] : ($prefillStoryId > 0 ? $prefillStoryId : 0);
        $vNo       = $isEdit ? (int) $row['chapter_number'] : 0;
        $vTitle    = $isEdit ? (string) $row['title'] : '';
        $vContent  = $isEdit ? (string) $row['content'] : '';
        $vStatus   = $isEdit ? (int) $row['status'] : 1;

        $vSeoTitle = $isEdit && array_key_exists('seo_title', $row) ? (string) $row['seo_title'] : '';
        $vSeoDesc  = $isEdit && array_key_exists('seo_description', $row) ? (string) $row['seo_description'] : '';

        $nextNo = 0;
        if (!$isEdit && $vStoryId > 0) {
            $maxNo = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT MAX(chapter_number) FROM {$table} WHERE story_id=%d",
                $vStoryId
            ));
            $nextNo = $maxNo + 1;
        }

        echo '<div class="wrap">';
        echo '<h1>' . esc_html($isEdit ? __('Edit Chapter', 'storymgr') : __('Add Chapter', 'storymgr')) . '</h1>';

        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';

        if ($isEdit) {
            echo '<input type="hidden" name="action" value="storymgr_update_chapter" />';
            echo '<input type="hidden" name="chapter_id" value="' . esc_attr($chapterId) . '" />';
            wp_nonce_field('storymgr_update_chapter_' . $chapterId, 'storymgr_nonce');
        } else {
            echo '<input type="hidden" name="action" value="storymgr_save_chapter" />';
            wp_nonce_field('storymgr_save_chapter', 'storymgr_nonce');
        }

        echo '<table class="form-table"><tbody>';

        echo '<tr><th><label for="story_id">' . esc_html__('Story', 'storymgr') . '</label></th><td>';
        echo '<select name="story_id" id="story_id" required>';
        echo '<option value="">' . esc_html__('-- Select story --', 'storymgr') . '</option>';
        foreach ($stories as $s) {
            $t = $s->post_title ? $s->post_title : ('#' . $s->ID);
            echo '<option value="' . esc_attr($s->ID) . '" ' . selected($vStoryId, (int) $s->ID, false) . '>' . esc_html($t) . '</option>';
        }
        echo '</select>';
        if (!$isEdit) {
            echo '<p class="description">' . esc_html__('Chapter number will be auto-generated (next number).', 'storymgr') . '</p>';
        }
        echo '</td></tr>';

        echo '<tr><th>' . esc_html__('Chapter number', 'storymgr') . '</th><td>';
        if ($isEdit) {
            echo '<input type="text" class="regular-text" value="' . esc_attr($vNo) . '" readonly />';
            echo '<p class="description">' . esc_html__('Chapter number is locked to avoid duplicates and messy ordering.', 'storymgr') . '</p>';
        } else {
            $label = ($nextNo > 0) ? (string) $nextNo : esc_html__('Auto', 'storymgr');
            echo '<input type="text" class="regular-text" value="' . esc_attr($label) . '" readonly />';
            echo '<p class="description">' . esc_html__('Select a story and save. System will assign the next chapter number.', 'storymgr') . '</p>';
        }
        echo '</td></tr>';

        echo '<tr><th><label for="title">' . esc_html__('Title', 'storymgr') . '</label></th><td>';
        echo '<input type="text" class="regular-text" name="title" id="title" required value="' . esc_attr($vTitle) . '" />';
        echo '</td></tr>';

        echo '<tr><th>' . esc_html__('Content', 'storymgr') . '</th><td>';
        wp_editor($vContent, 'content', [
            'textarea_name' => 'content',
            'media_buttons' => false,
            'teeny'         => true,
            'textarea_rows' => 14,
        ]);
        echo '</td></tr>';

        echo '<tr><th><label for="seo_title">' . esc_html__('SEO Title', 'storymgr') . '</label></th><td>';
        echo '<input type="text" class="regular-text" name="seo_title" id="seo_title" value="' . esc_attr($vSeoTitle) . '" />';
        echo '<p class="description">' . esc_html__('Optional. If empty, it will use Chapter Title + Story Title.', 'storymgr') . '</p>';
        echo '</td></tr>';

        echo '<tr><th><label for="seo_description">' . esc_html__('SEO Description', 'storymgr') . '</label></th><td>';
        echo '<textarea class="large-text" rows="3" name="seo_description" id="seo_description">' . esc_textarea($vSeoDesc) . '</textarea>';
        echo '<p class="description">' . esc_html__('Optional. If empty, it will use the beginning of chapter content.', 'storymgr') . '</p>';
        echo '</td></tr>';

        echo '<tr><th><label for="status">' . esc_html__('Status', 'storymgr') . '</label></th><td>';
        echo '<select name="status" id="status">';
        echo '<option value="1" ' . selected($vStatus, 1, false) . '>' . esc_html__('Published', 'storymgr') . '</option>';
        echo '<option value="0" ' . selected($vStatus, 0, false) . '>' . esc_html__('Draft', 'storymgr') . '</option>';
        echo '</select>';
        echo '</td></tr>';

        echo '</tbody></table>';

        submit_button($isEdit ? __('Update Chapter', 'storymgr') : __('Save Chapter', 'storymgr'));

        echo '</form>';
        echo '</div>';
    }

    public static function renderViewChapterPage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $chapterId = isset($_GET['chapter_id']) ? absint($_GET['chapter_id']) : 0;
        if ($chapterId <= 0) wp_die(esc_html__('Invalid chapter', 'storymgr'));

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $chapterId), ARRAY_A);
        if (!$row) wp_die(esc_html__('Chapter not found', 'storymgr'));

        $storyId = (int) $row['story_id'];
        $storyTitle = get_the_title($storyId);
        $storyTitle = $storyTitle ? $storyTitle : ('#' . $storyId);

        $editUrl = add_query_arg(['page' => 'storymgr-add-chapter', 'chapter_id' => $chapterId], admin_url('admin.php'));
        $backUrl = admin_url('admin.php?page=storymgr-chapters');

        echo '<div class="wrap">';
        echo '<h1>' . esc_html($storyTitle) . ' — ' . sprintf(esc_html__('Chapter %d', 'storymgr'), (int) $row['chapter_number']) . '</h1>';

        echo '<p style="margin:10px 0;">';
        echo '<a class="button" href="' . esc_url($backUrl) . '">' . esc_html__('Back to list', 'storymgr') . '</a> ';
        echo '<a class="button button-primary" href="' . esc_url($editUrl) . '">' . esc_html__('Edit', 'storymgr') . '</a>';
        echo '</p>';

        echo '<hr/>';

        echo '<h2>' . esc_html((string) $row['title']) . '</h2>';

        echo '<div style="background:#fff; padding:16px; border:1px solid #e5e5e5; border-radius:6px;">';
        echo wp_kses_post((string) $row['content']);
        echo '</div>';

        echo '</div>';
    }

    public static function renderProgressPage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $table = new ProgressListTable();
        $table->prepare_items();

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('User Progress', 'storymgr') . '</h1>';

        if (isset($_GET['deleted'])) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Progress row deleted.', 'storymgr') . '</p></div>';
        }

        $userId  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

        echo '<form method="get" style="margin:12px 0; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">';
        echo '<input type="hidden" name="page" value="storymgr-progress" />';
        echo '<label for="storymgr_progress_user_id">' . esc_html__('User ID', 'storymgr') . '</label>';
        echo '<input type="number" id="storymgr_progress_user_id" name="user_id" placeholder="user_id" value="' . esc_attr($userId) . '" />';
        echo '<label for="storymgr_progress_story_id">' . esc_html__('Story ID', 'storymgr') . '</label>';
        echo '<input type="number" id="storymgr_progress_story_id" name="story_id" placeholder="story_id" value="' . esc_attr($storyId) . '" />';
        submit_button(__('Filter', 'storymgr'), 'secondary', '', false);
        echo '</form>';

        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="storymgr-progress" />';
        echo '<input type="hidden" name="user_id" value="' . esc_attr($userId) . '" />';
        echo '<input type="hidden" name="story_id" value="' . esc_attr($storyId) . '" />';
        $table->display();
        echo '</form>';

        echo '</div>';
    }

    public static function renderFavoritesPage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $table = new FavoritesListTable();
        $table->prepare_items();

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Favorites', 'storymgr') . '</h1>';

        if (isset($_GET['deleted'])) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Favorite removed.', 'storymgr') . '</p></div>';
        }

        $userId  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

        echo '<form method="get" style="margin:12px 0; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">';
        echo '<input type="hidden" name="page" value="storymgr-favorites" />';
        echo '<label for="storymgr_favorites_user_id">' . esc_html__('User ID', 'storymgr') . '</label>';
        echo '<input type="number" id="storymgr_favorites_user_id" name="user_id" placeholder="user_id" value="' . esc_attr($userId) . '" />';
        echo '<label for="storymgr_favorites_story_id">' . esc_html__('Story ID', 'storymgr') . '</label>';
        echo '<input type="number" id="storymgr_favorites_story_id" name="story_id" placeholder="story_id" value="' . esc_attr($storyId) . '" />';
        submit_button(__('Filter', 'storymgr'), 'secondary', '', false);
        echo '</form>';

        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="storymgr-favorites" />';
        echo '<input type="hidden" name="user_id" value="' . esc_attr($userId) . '" />';
        echo '<input type="hidden" name="story_id" value="' . esc_attr($storyId) . '" />';
        $table->display();
        echo '</form>';

        echo '</div>';
    }

    public static function renderCachePage(): void {
        if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

        $table = new CacheListTable();
        $table->prepare_items();

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Story Cache (Stats)', 'storymgr') . '</h1>';

        if (isset($_GET['rebuilt'])) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Cache rebuilt.', 'storymgr') . '</p></div>';
        }
        if (isset($_GET['rebuilt_all'])) {
            echo '<div class="notice notice-success is-dismissible"><p>' .
                sprintf(esc_html__('Rebuilt %d stories.', 'storymgr'), absint($_GET['rebuilt_all'])) .
            '</p></div>';
        }

        echo '<div style="margin:12px 0;">';
        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        echo '<input type="hidden" name="action" value="storymgr_rebuild_all_cache" />';
        wp_nonce_field('storymgr_rebuild_all_cache', 'storymgr_nonce');
        submit_button(__('Rebuild All', 'storymgr'), 'secondary', 'submit', false);
        echo '</form>';
        echo '</div>';

        $table->display();

        echo '</div>';
    }
}
