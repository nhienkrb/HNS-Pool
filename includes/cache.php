<?php
defined('ABSPATH') || exit;

function storymgr_table_chapters() {
    global $wpdb;
    return $wpdb->prefix . 'story_chapters';
}

function storymgr_table_cache() {
    global $wpdb;
    return $wpdb->prefix . 'story_cache';
}

function storymgr_rebuild_story_cache($story_id) {
    global $wpdb;

    $story_id = (int) $story_id;
    if ($story_id <= 0) return false;

    $chapters = storymgr_table_chapters();
    $cache    = storymgr_table_cache();

    $total = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$chapters} WHERE story_id = %d",
        $story_id
    ));

    $last_at = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(created_at) FROM {$chapters} WHERE story_id = %d",
        $story_id
    ));
    $last_at = $last_at ? $last_at : null;

    //  current total_views if row exists
    $views = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT total_views FROM {$cache} WHERE story_id = %d",
        $story_id
    ));

    $now = current_time('mysql');

    // Replace (insert or update)
    $ok = $wpdb->replace(
        $cache,
        [
            'story_id'        => $story_id,
            'total_chapters'  => $total,
            'total_views'     => $views,
            'last_chapter_at' => $last_at,
            'updated_at'      => $now,
        ],
        ['%d','%d','%d','%s','%s']
    );

    return ($ok !== false);
}


function storymgr_rebuild_all_cache() {
    global $wpdb;

    $chapters = storymgr_table_chapters();
    $story_ids = $wpdb->get_col("SELECT DISTINCT story_id FROM {$chapters}");

    if (empty($story_ids)) return 0;

    $count = 0;
    foreach ($story_ids as $sid) {
        if (storymgr_rebuild_story_cache((int)$sid)) $count++;
    }
    return $count;
}


function storymgr_increment_story_view($story_id, $by = 1) {
    global $wpdb;

    $story_id = (int)$story_id;
    $by       = max(1, (int)$by);
    if ($story_id <= 0) return false;

    $cache = storymgr_table_cache();
    $now   = current_time('mysql');


    $wpdb->query($wpdb->prepare(
        "INSERT INTO {$cache} (story_id, total_chapters, total_views, last_chapter_at, updated_at)
         VALUES (%d, 0, 0, NULL, %s)
         ON DUPLICATE KEY UPDATE updated_at = VALUES(updated_at)",
        $story_id, $now
    ));

    return $wpdb->query($wpdb->prepare(
        "UPDATE {$cache} SET total_views = total_views + %d, updated_at = %s WHERE story_id = %d",
        $by, $now, $story_id
    ));
}

/** Admin  */
function storymgr_handle_rebuild_story_cache() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $story_id = isset($_GET['story_id']) ? absint($_GET['story_id']) : 0;
    $nonce    = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

    if ($story_id <= 0 || !wp_verify_nonce($nonce, 'storymgr_rebuild_cache_' . $story_id)) {
        wp_die(esc_html__('Invalid request', 'storymgr'));
    }

    storymgr_rebuild_story_cache($story_id);
    wp_safe_redirect(admin_url('admin.php?page=storymgr-cache&rebuilt=1'));
    exit;
}

function storymgr_handle_rebuild_all_cache() {
    if (!current_user_can('manage_options')) wp_die(esc_html__('No permission', 'storymgr'));

    $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'storymgr_rebuild_all_cache')) {
        wp_die(esc_html__('Invalid request', 'storymgr'));
    }

    $count = storymgr_rebuild_all_cache();
    wp_safe_redirect(admin_url('admin.php?page=storymgr-cache&rebuilt_all=' . (int)$count));
    exit;
}
