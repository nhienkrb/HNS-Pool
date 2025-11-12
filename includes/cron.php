<?php

require_once plugin_dir_path(__FILE__) . 'handle_syn_sheet.php';

add_action('sync_daily_sync', function () {
    $opts = get_option('sync_options', []);
    if (!empty($opts['auto_sync']) || $opts['auto_sync'] === 1) {
        error_log('Cron: đồng bộ Sheet → DB');
        sync_products();
    }

    if (!empty($opts['auto_sync_to_sheet']) || $opts['auto_sync_to_sheet'] === 1) {
        error_log('Cron: đồng bộ DB → Sheet');
        sync_to_sheets();
    }
});

function sync_schedule_daily_sync()
{
    if (!wp_next_scheduled('sync_daily_sync')) {
        $timestamp = strtotime('tomorrow 03:00');
        wp_schedule_event($timestamp, 'daily', 'sync_daily_sync');
    }
}

function sync_unschedule_daily_sync()
{
    $timestamp = wp_next_scheduled('sync_daily_sync');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'sync_daily_sync');
    }
}

register_activation_hook(__FILE__, 'sync_schedule_daily_sync');
register_deactivation_hook(__FILE__, 'sync_unschedule_daily_sync');
