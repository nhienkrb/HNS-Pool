<?php
/**
 * Plugin Name: Story Manager 
 * Description: Admin.
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

define('STORYMGR_VERSION', '1.0.0');

$autoload = dirname(__DIR__, 4) . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

if (class_exists(\StoryMgr\Plugin::class)) {
    \StoryMgr\Plugin::init(__FILE__);
    register_activation_hook(__FILE__, [\StoryMgr\Plugin::class, 'activate']);
    register_deactivation_hook(__FILE__, [\StoryMgr\Plugin::class, 'deactivate']);
}
