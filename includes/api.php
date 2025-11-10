<?php


require_once plugin_dir_path(__FILE__) . 'handle_syn_sheet.php';

add_action('rest_api_init', function () {

    register_rest_route('sync/v1', '/preview', [
        'methods'  => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function () {
            $rows = sync_read_sheet();
            $preview = [];
            foreach ($rows as $r) {
                $errors = sync_validate_row($r);
                $preview[] = [
                    'data' => $r,
                    'errors' => $errors,
                    'valid' => empty($errors)
                ];
            }
            return rest_ensure_response($preview);
        }
    ]);

    register_rest_route('sync/v1', '/products', [
        'methods'  => 'POST',
        'permission_callback' => '__return_true',
        'callback' => function () {
            $res = sync_products();
            return rest_ensure_response($res);
        }
    ]);
});
