<?php
defined('ABSPATH') || exit;

function storymgr_register_admin_menu() {
    $cap = 'manage_options'; 

    add_menu_page(
        __('Story Manager', 'storymgr'),
        __('Story Manager', 'storymgr'),
        $cap,
        'storymgr',
        'storymgr_render_dashboard',
        'dashicons-book-alt',
        26
    );

    add_submenu_page(
        'storymgr',
        __('Chapters', 'storymgr'),
        __('Chapters', 'storymgr'),
        $cap,
        'storymgr-chapters',
        'storymgr_render_chapters_page'
    );

    add_submenu_page(
        'storymgr',
        __('Add Chapter', 'storymgr'),
        __('Add Chapter', 'storymgr'),
        $cap,
        'storymgr-add-chapter',
        'storymgr_render_add_chapter_page'
    );

    add_submenu_page(
        'storymgr',
        __('User Progress', 'storymgr'),
        __('User Progress', 'storymgr'),
        $cap,
        'storymgr-progress',
        'storymgr_render_progress_page'
    );

    add_submenu_page(
        'storymgr',
        __('Story Cache', 'storymgr'),
        __('Story Cache', 'storymgr'),
        $cap,
        'storymgr-cache',
        'storymgr_render_cache_page'
    );
}
