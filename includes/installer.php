<?php
defined('ABSPATH') || exit;

function storymgr_install_tables() {
    if (!current_user_can('activate_plugins')) {
        return;
    }

    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();

    $chapters = $wpdb->prefix . 'story_chapters';
    $progress = $wpdb->prefix . 'user_story_progress';
    $cache    = $wpdb->prefix . 'story_cache';

    // Chapters 
    $sql1 = "CREATE TABLE {$chapters} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        story_id BIGINT UNSIGNED NOT NULL,
        chapter_number INT UNSIGNED NOT NULL,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(200) NOT NULL,
        content LONGTEXT NULL,
        status TINYINT(1) NOT NULL DEFAULT 1,
        word_count INT UNSIGNED NOT NULL DEFAULT 0,
        published_at DATETIME NULL,
        created_by BIGINT UNSIGNED NULL,
        updated_by BIGINT UNSIGNED NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY uniq_story_chapno (story_id, chapter_number),
        UNIQUE KEY uniq_story_slug (story_id, slug),
        KEY idx_story_status_no (story_id, status, chapter_number),
        KEY idx_story_published_at (story_id, published_at),
        KEY idx_story_updated (story_id, updated_at)
    ) {$charset_collate};";

    //  User progress 
    $sql2 = "CREATE TABLE {$progress} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        story_id BIGINT UNSIGNED NOT NULL,
        chapter_id BIGINT UNSIGNED NULL,
        chapter_number INT UNSIGNED NULL,
        progress_percent DECIMAL(5,2) NOT NULL DEFAULT 0.00,
        last_read_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY uniq_user_story (user_id, story_id),
        KEY idx_user_lastread (user_id, last_read_at),
        KEY idx_story_users (story_id, last_read_at)
    ) {$charset_collate};";

    // Story cache
    $sql3 = "CREATE TABLE {$cache} (
        story_id BIGINT UNSIGNED NOT NULL,
        total_chapters INT UNSIGNED NOT NULL DEFAULT 0,
        total_views BIGINT UNSIGNED NOT NULL DEFAULT 0,
        last_chapter_id BIGINT UNSIGNED NULL,
        last_chapter_number INT UNSIGNED NULL,
        last_chapter_at DATETIME NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (story_id),
        KEY idx_last_chapter_at (last_chapter_at),
        KEY idx_views (total_views)
    ) {$charset_collate};";

    dbDelta($sql1);
    dbDelta($sql2);
    dbDelta($sql3);
}
