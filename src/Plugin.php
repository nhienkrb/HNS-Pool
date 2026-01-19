<?php
namespace StoryMgr;

use StoryMgr\Admin\Menu;
use StoryMgr\Auth\Auth;
use StoryMgr\Database\Installer;
use StoryMgr\Features\Favorites;
use StoryMgr\Features\Progress;
use StoryMgr\Features\Views;
use StoryMgr\Frontend\Frontend;
use StoryMgr\Shortcodes\Shortcodes;
use StoryMgr\Taxonomies\Taxonomies;
use StoryMgr\Admin\ChapterCrud;
use StoryMgr\Features\Cache;

final class Plugin {
    private static string $baseFile;

    public static function init(string $baseFile): void {
        self::$baseFile = $baseFile;

        add_action('init', [Frontend::class, 'registerChapterPostType']);
        add_action('init', [Frontend::class, 'registerChapterRewrites']);
        add_filter('query_vars', [Frontend::class, 'addQueryVars']);
        add_filter('the_posts', [Frontend::class, 'injectVirtualChapter'], 10, 2);

        add_filter('document_title_parts', [Frontend::class, 'chapterDocumentTitle']);
        add_action('wp_head', [Frontend::class, 'chapterMetaDescription'], 1);
        add_filter('wpseo_title', [Frontend::class, 'chapterWpseoTitle']);
        add_filter('wpseo_metadesc', [Frontend::class, 'chapterWpseoMetadesc']);
        add_filter('rank_math/frontend/title', [Frontend::class, 'chapterRankMathTitle']);
        add_filter('rank_math/frontend/description', [Frontend::class, 'chapterRankMathDescription']);
        add_filter('pre_get_shortlink', [Frontend::class, 'preGetShortlink'], 10, 4);

        add_action('init', [Taxonomies::class, 'register']);
        add_action('admin_menu', [Menu::class, 'register']);

        add_action('admin_post_storymgr_save_chapter', [ChapterCrud::class, 'handleSaveChapter']);
        add_action('admin_post_storymgr_update_chapter', [ChapterCrud::class, 'handleUpdateChapter']);
        add_action('admin_post_storymgr_delete_chapter', [ChapterCrud::class, 'handleDeleteChapter']);

        add_action('admin_post_storymgr_rebuild_story_cache', [Cache::class, 'handleRebuildStoryCache']);
        add_action('admin_post_storymgr_rebuild_all_cache', [Cache::class, 'handleRebuildAllCache']);

        add_action('admin_post_storymgr_delete_progress', [Progress::class, 'handleDeleteProgress']);

        add_action('admin_post_storymgr_toggle_favorite', [Favorites::class, 'handleToggleFavorite']);
        add_action('admin_post_nopriv_storymgr_toggle_favorite', [Favorites::class, 'handleToggleFavorite']);
        add_action('admin_post_storymgr_delete_favorite', [Favorites::class, 'handleDeleteFavorite']);

        add_action('admin_post_storymgr_register', [Auth::class, 'handleRegister']);
        add_action('admin_post_nopriv_storymgr_register', [Auth::class, 'handleRegister']);
        add_action('admin_init', [Auth::class, 'blockWpAdmin']);

        add_filter('cron_schedules', [Views::class, 'registerViewCron']);
        add_action('storymgr_flush_chapter_views', [Views::class, 'flushChapterViews']);
        add_filter('the_content', [Views::class, 'appendViewMeta'], 20);

        add_action('wp_enqueue_scripts', [Progress::class, 'enqueueReadingProgressScript']);
        add_action('wp_ajax_storymgr_update_progress', [Progress::class, 'handleUpdateProgressAjax']);
        add_action('wp_ajax_nopriv_storymgr_update_progress', [Progress::class, 'handleUpdateProgressAjax']);

        add_shortcode('storymgr_login', [Shortcodes::class, 'login']);
        add_shortcode('storymgr_register', [Shortcodes::class, 'register']);
        add_shortcode('storymgr_favorite_button', [Shortcodes::class, 'favoriteButton']);
        add_shortcode('storymgr_account', [Shortcodes::class, 'account']);
        add_shortcode('storymgr_dashboard', [Shortcodes::class, 'dashboard']);
    }

    public static function activate(): void {
        Installer::installTables();
        Frontend::registerChapterRewrites();
        Views::scheduleViewFlush();
        flush_rewrite_rules();
    }

    public static function deactivate(): void {
        Views::clearViewFlush(); //cache scheduled view
        flush_rewrite_rules();
    }

    public static function path(string $path = ''): string {
        $base = plugin_dir_path(self::$baseFile);
        return $path ? $base . ltrim($path, '/') : $base;
    }

    public static function url(string $path = ''): string {
        $base = plugin_dir_url(self::$baseFile);
        return $path ? $base . ltrim($path, '/') : $base;
    }

    public static function version(): string {
        return '1.0.0';
    }
}
