<?php
defined('ABSPATH') || exit;

function storymgr_table_progress() {
    global $wpdb;
    return $wpdb->prefix . 'user_story_progress';
}


function storymgr_set_user_story_progress($user_id, $story_id, $chapter_id) {
    global $wpdb;

    $user_id    = (int)$user_id;
    $story_id   = (int)$story_id;
    $chapter_id = $chapter_id ? (int)$chapter_id : null;

    if ($user_id <= 0 || $story_id <= 0) return false;

    $table = storymgr_table_progress();
    $now   = current_time('mysql');

    // INSERT 
    $sql = $wpdb->prepare(
        "INSERT INTO {$table} (user_id, story_id, chapter_id, updated_at)
         VALUES (%d, %d, %s, %s)
         ON DUPLICATE KEY UPDATE chapter_id = VALUES(chapter_id), updated_at = VALUES(updated_at)",
        $user_id, $story_id, $chapter_id, $now
    );

    return $wpdb->query($sql);
}

// delete  
function storymgr_handle_delete_progress() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $id    = isset($_GET['id']) ? absint($_GET['id']) : 0;
    $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

    if ($id <= 0 || !wp_verify_nonce($nonce, 'storymgr_delete_progress_' . $id)) {
        wp_die(esc_html__('Invalid request', 'storymgr'));
    }

    global $wpdb;
    $table = storymgr_table_progress();

    $wpdb->delete($table, ['id' => $id], ['%d']);

    wp_safe_redirect(admin_url('admin.php?page=storymgr-progress&deleted=1'));
    exit;
}
