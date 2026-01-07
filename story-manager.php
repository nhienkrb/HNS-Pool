<?php
/**
 * Plugin Name: Story Manager 
 * Description: Admin.
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

define('STORYMGR_PATH', plugin_dir_path(__FILE__));
define('STORYMGR_VERSION', '1.0.0');

require_once STORYMGR_PATH . 'includes/installer.php';
require_once STORYMGR_PATH . 'includes/cache.php';
require_once STORYMGR_PATH . 'includes/progress.php';

require_once STORYMGR_PATH . 'includes/class-chapter-list-table.php';
require_once STORYMGR_PATH . 'includes/class-progress-list-table.php';
require_once STORYMGR_PATH . 'includes/class-cache-list-table.php';

require_once STORYMGR_PATH . 'includes/admin-menu.php';
require_once STORYMGR_PATH . 'includes/admin-pages.php';
require_once STORYMGR_PATH . 'includes/chapter-crud.php';

// Create tables on activation
register_activation_hook(__FILE__, 'storymgr_install_tables');

// Admin menu
add_action('admin_menu', 'storymgr_register_admin_menu');

// Chapter CRUD handlers
add_action('admin_post_storymgr_save_chapter', 'storymgr_handle_save_chapter');
add_action('admin_post_storymgr_update_chapter', 'storymgr_handle_update_chapter');
add_action('admin_post_storymgr_delete_chapter', 'storymgr_handle_delete_chapter');

// Cache handlers 
add_action('admin_post_storymgr_rebuild_story_cache', 'storymgr_handle_rebuild_story_cache');
add_action('admin_post_storymgr_rebuild_all_cache', 'storymgr_handle_rebuild_all_cache');

// Progress handlers 
add_action('admin_post_storymgr_delete_progress', 'storymgr_handle_delete_progress');
