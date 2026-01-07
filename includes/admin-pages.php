<?php
defined('ABSPATH') || exit;

function storymgr_render_dashboard() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Story Manager', 'storymgr') . '</h1>';
    echo '</div>';
}

function storymgr_render_chapters_page() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $table = new StoryMGR_Chapter_List_Table();
    $table->process_bulk_action();
    $table->prepare_items();

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Chapters', 'storymgr') . '</h1>';

    if (isset($_GET['saved']))   echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter saved.', 'storymgr') . '</p></div>';
    if (isset($_GET['updated'])) echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter updated.', 'storymgr') . '</p></div>';
    if (isset($_GET['deleted'])) echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Chapter deleted.', 'storymgr') . '</p></div>';
    if (isset($_GET['deleted_count'])) echo '<div class="notice notice-success is-dismissible"><p>' . sprintf(esc_html__('Deleted %d chapters.', 'storymgr'), absint($_GET['deleted_count'])) . '</p></div>';

    $story_id = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;
    $status   = isset($_REQUEST['status']) ? sanitize_text_field(wp_unslash($_REQUEST['status'])) : '';

    // Filter form
    $stories = get_posts([
        'post_type'      => 'post',
        'post_status'    => ['publish','draft'],
        'posts_per_page' => 100,
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
        echo '<option value="' . esc_attr($s->ID) . '" ' . selected($story_id, (int)$s->ID, false) . '>' . esc_html($t) . '</option>';
    }
    echo '</select>';

    echo '<select name="status">';
    echo '<option value="">' . esc_html__('All statuses', 'storymgr') . '</option>';
    echo '<option value="published" ' . selected($status, 'published', false) . '>' . esc_html__('Published', 'storymgr') . '</option>';
    echo '<option value="draft" ' . selected($status, 'draft', false) . '>' . esc_html__('Draft', 'storymgr') . '</option>';
    echo '</select>';

    submit_button(__('Filter', 'storymgr'), 'secondary', '', false);
    echo '</form>';

    echo '<a class="button button-primary" href="' . esc_url(admin_url('admin.php?page=storymgr-add-chapter')) . '">' . esc_html__('Add Chapter', 'storymgr') . '</a>';

    echo '</div>';

    // List table form 
    echo '<form method="get">';
    echo '<input type="hidden" name="page" value="storymgr-chapters" />';
    echo '<input type="hidden" name="story_id" value="' . esc_attr($story_id) . '" />';
    echo '<input type="hidden" name="status" value="' . esc_attr($status) . '" />';

    wp_nonce_field('storymgr_bulk_chapters');
    $table->search_box(__('Search title', 'storymgr'), 'storymgr-chapters');
    $table->display();

    echo '</form>';
    echo '</div>';
}

function storymgr_render_add_chapter_page() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    global $wpdb;
    $table = $wpdb->prefix . 'story_chapters';

    $chapter_id = isset($_GET['chapter_id']) ? absint($_GET['chapter_id']) : 0;
    $is_edit = $chapter_id > 0;

    $row = null;
    if ($is_edit) {
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $chapter_id), ARRAY_A);
        if (!$row) wp_die(esc_html__('Chapter not found', 'storymgr'));
    }

    $stories = get_posts([
        'post_type'      => 'post',
        'post_status'    => ['publish','draft'],
        'posts_per_page' => 100,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);

    $v_story_id = $is_edit ? (int)$row['story_id'] : 0;
    $v_no       = $is_edit ? (int)$row['chapter_number'] : '';
    $v_title    = $is_edit ? (string)$row['title'] : '';
    $v_content  = $is_edit ? (string)$row['content'] : '';
    $v_status   = $is_edit ? (int)$row['status'] : 1;

    echo '<div class="wrap">';
    echo '<h1>' . esc_html($is_edit ? __('Edit Chapter', 'storymgr') : __('Add Chapter', 'storymgr')) . '</h1>';

    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';

    if ($is_edit) {
        echo '<input type="hidden" name="action" value="storymgr_update_chapter" />';
        echo '<input type="hidden" name="chapter_id" value="' . esc_attr($chapter_id) . '" />';
        wp_nonce_field('storymgr_update_chapter_' . $chapter_id, 'storymgr_nonce');
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
        echo '<option value="' . esc_attr($s->ID) . '" ' . selected($v_story_id, (int)$s->ID, false) . '>' . esc_html($t) . '</option>';
    }
    echo '</select></td></tr>';

    echo '<tr><th><label for="chapter_number">' . esc_html__('Chapter number', 'storymgr') . '</label></th><td>';
    echo '<input type="number" min="1" name="chapter_number" id="chapter_number" required value="' . esc_attr($v_no) . '" />';
    echo '</td></tr>';

    echo '<tr><th><label for="title">' . esc_html__('Title', 'storymgr') . '</label></th><td>';
    echo '<input type="text" class="regular-text" name="title" id="title" required value="' . esc_attr($v_title) . '" />';
    echo '</td></tr>';

    echo '<tr><th>' . esc_html__('Content', 'storymgr') . '</th><td>';
    wp_editor($v_content, 'content', [
        'textarea_name' => 'content',
        'media_buttons' => false,
        'teeny'         => true,
        'textarea_rows' => 14,
    ]);
    echo '</td></tr>';

    echo '<tr><th><label for="status">' . esc_html__('Status', 'storymgr') . '</label></th><td>';
    echo '<select name="status" id="status">';
    echo '<option value="1" ' . selected($v_status, 1, false) . '>' . esc_html__('Published', 'storymgr') . '</option>';
    echo '<option value="0" ' . selected($v_status, 0, false) . '>' . esc_html__('Draft', 'storymgr') . '</option>';
    echo '</select>';
    echo '</td></tr>';

    echo '</tbody></table>';

    submit_button($is_edit ? __('Update Chapter', 'storymgr') : __('Save Chapter', 'storymgr'));

    echo '</form>';
    echo '</div>';
}

function storymgr_render_progress_page() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $table = new StoryMGR_Progress_List_Table();
    $table->prepare_items();

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('User Progress', 'storymgr') . '</h1>';

    if (isset($_GET['deleted'])) {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Progress row deleted.', 'storymgr') . '</p></div>';
    }

    $user_id  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
    $story_id = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

    echo '<form method="get" style="margin:12px 0; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">';
    echo '<input type="hidden" name="page" value="storymgr-progress" />';
    echo '<input type="number" name="user_id" placeholder="user_id" value="' . esc_attr($user_id) . '" />';
    echo '<input type="number" name="story_id" placeholder="story_id" value="' . esc_attr($story_id) . '" />';
    submit_button(__('Filter', 'storymgr'), 'secondary', '', false);
    echo '</form>';

    echo '<form method="get">';
    echo '<input type="hidden" name="page" value="storymgr-progress" />';
    echo '<input type="hidden" name="user_id" value="' . esc_attr($user_id) . '" />';
    echo '<input type="hidden" name="story_id" value="' . esc_attr($story_id) . '" />';
    $table->display();
    echo '</form>';

    echo '</div>';
}

function storymgr_render_cache_page() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $table = new StoryMGR_Cache_List_Table();
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
