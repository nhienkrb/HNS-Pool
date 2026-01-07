<?php
defined('ABSPATH') || exit;

function storymgr_get_story_post($story_id) {
    $p = get_post((int)$story_id);
    if (!$p || $p->post_type !== 'post') return null;
    return $p;
}

function storymgr_handle_save_chapter() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'storymgr_save_chapter')) {
        wp_die(esc_html__('Invalid nonce', 'storymgr'));
    }

    global $wpdb;
    $table = $wpdb->prefix . 'story_chapters';

    $story_id       = isset($_POST['story_id']) ? absint($_POST['story_id']) : 0;
    $chapter_number = isset($_POST['chapter_number']) ? absint($_POST['chapter_number']) : 0;
    $title          = isset($_POST['title']) ? sanitize_text_field(wp_unslash($_POST['title'])) : '';
    $content        = isset($_POST['content']) ? wp_kses_post(wp_unslash($_POST['content'])) : '';
    $status         = isset($_POST['status']) ? absint($_POST['status']) : 0; // 1/0

    if ($story_id <= 0 || $chapter_number <= 0 || $title === '') {
        wp_die(esc_html__('Missing required fields', 'storymgr'));
    }
    if (!storymgr_get_story_post($story_id)) {
        wp_die(esc_html__('Invalid story', 'storymgr'));
    }

    $dup = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE story_id = %d AND chapter_number = %d",
        $story_id, $chapter_number
    ));
    if ($dup > 0) {
        wp_die(esc_html__('Duplicate chapter_number for this story', 'storymgr'));
    }

    $now = current_time('mysql');

    $ok = $wpdb->insert(
        $table,
        [
            'story_id'       => $story_id,
            'chapter_number' => $chapter_number,
            'title'          => $title,
            'content'        => $content,
            'status'         => $status ? 1 : 0,
            'created_at'     => $now,
            'updated_at'     => $now,
        ],
        ['%d','%d','%s','%s','%d','%s','%s']
    );

    if ($ok === false) wp_die(esc_html__('DB insert failed', 'storymgr'));

    // Update story_cache
    storymgr_rebuild_story_cache($story_id);

    wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&saved=1'));
    exit;
}

function storymgr_handle_update_chapter() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $chapter_id = isset($_POST['chapter_id']) ? absint($_POST['chapter_id']) : 0;
    if ($chapter_id <= 0) wp_die(esc_html__('Invalid chapter_id', 'storymgr'));

    $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'storymgr_update_chapter_' . $chapter_id)) {
        wp_die(esc_html__('Invalid nonce', 'storymgr'));
    }

    global $wpdb;
    $table = $wpdb->prefix . 'story_chapters';

    $story_id       = isset($_POST['story_id']) ? absint($_POST['story_id']) : 0;
    $chapter_number = isset($_POST['chapter_number']) ? absint($_POST['chapter_number']) : 0;
    $title          = isset($_POST['title']) ? sanitize_text_field(wp_unslash($_POST['title'])) : '';
    $content        = isset($_POST['content']) ? wp_kses_post(wp_unslash($_POST['content'])) : '';
    $status         = isset($_POST['status']) ? absint($_POST['status']) : 0;

    if ($story_id <= 0 || $chapter_number <= 0 || $title === '') {
        wp_die(esc_html__('Missing required fields', 'storymgr'));
    }
    if (!storymgr_get_story_post($story_id)) {
        wp_die(esc_html__('Invalid story', 'storymgr'));
    }

    // Duplicate check exclude current
    $dup = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE story_id = %d AND chapter_number = %d AND id != %d",
        $story_id, $chapter_number, $chapter_id
    ));
    if ($dup > 0) {
        wp_die(esc_html__('Duplicate chapter_number for this story', 'storymgr'));
    }

    $now = current_time('mysql');

    $ok = $wpdb->update(
        $table,
        [
            'story_id'       => $story_id,
            'chapter_number' => $chapter_number,
            'title'          => $title,
            'content'        => $content,
            'status'         => $status ? 1 : 0,
            'updated_at'     => $now,
        ],
        ['id' => $chapter_id],
        ['%d','%d','%s','%s','%d','%s'],
        ['%d']
    );

    if ($ok === false) wp_die(esc_html__('DB update failed', 'storymgr'));

    storymgr_rebuild_story_cache($story_id);

    wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&updated=1'));
    exit;
}

function storymgr_handle_delete_chapter() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $chapter_id = isset($_GET['chapter_id']) ? absint($_GET['chapter_id']) : 0;
    $nonce      = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

    if ($chapter_id <= 0 || !wp_verify_nonce($nonce, 'storymgr_delete_chapter_' . $chapter_id)) {
        wp_die(esc_html__('Invalid request', 'storymgr'));
    }

    global $wpdb;
    $table = $wpdb->prefix . 'story_chapters';

    $story_id = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT story_id FROM {$table} WHERE id = %d",
        $chapter_id
    ));

    $ok = $wpdb->delete($table, ['id' => $chapter_id], ['%d']);
    if ($ok === false) wp_die(esc_html__('DB delete failed', 'storymgr'));

    if ($story_id > 0) {
        storymgr_rebuild_story_cache($story_id);
    }

    wp_safe_redirect(admin_url('admin.php?page=storymgr-chapters&deleted=1'));
    exit;
}
