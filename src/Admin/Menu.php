<?php
namespace StoryMgr\Admin;

final class Menu {
    public static function register(): void {
        $cap = 'manage_options';

        add_menu_page(
            __('Story Manager', 'storymgr'),
            __('Story Manager', 'storymgr'),
            $cap,
            'storymgr',
            [Pages::class, 'renderDashboard'],
            'dashicons-book-alt',
            26
        );

        add_submenu_page(
            'storymgr',
            __('Chapters', 'storymgr'),
            __('Chapters', 'storymgr'),
            $cap,
            'storymgr-chapters',
            [Pages::class, 'renderChaptersPage']
        );

        add_submenu_page(
            'storymgr',
            __('Add Chapter', 'storymgr'),
            __('Add Chapter', 'storymgr'),
            $cap,
            'storymgr-add-chapter',
            [Pages::class, 'renderAddChapterPage']
        );

        add_submenu_page(
            'storymgr',
            __('User Progress', 'storymgr'),
            __('User Progress', 'storymgr'),
            $cap,
            'storymgr-progress',
            [Pages::class, 'renderProgressPage']
        );

        add_submenu_page(
            'storymgr',
            __('Favorites', 'storymgr'),
            __('Favorites', 'storymgr'),
            $cap,
            'storymgr-favorites',
            [Pages::class, 'renderFavoritesPage']
        );

        add_submenu_page(
            'storymgr',
            __('Story Cache', 'storymgr'),
            __('Story Cache', 'storymgr'),
            $cap,
            'storymgr-cache',
            [Pages::class, 'renderCachePage']
        );

        add_submenu_page(
            'storymgr',
            __('View Chapter', 'storymgr'),
            __('View Chapter', 'storymgr'),
            $cap,
            'storymgr-view-chapter',
            [Pages::class, 'renderViewChapterPage']
        );
    }
}
