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

    register_rest_route('sync/v1', '/push', [
        'methods' => 'POST',
        'permission_callback' => '__return_true',
        'callback' => function () {
            if (!function_exists('sync_to_sheets')) {
                return new WP_Error('no_function', 'Hàm sync_to_sheets() chưa khởi tạo');
            }
            $res = sync_to_sheets();
            return rest_ensure_response($res);
        }
    ]);
});

add_action('wp_ajax_sync_save_product', function () {
    check_ajax_referer('sync_save_nonce');

    global $wpdb;
    $table = $wpdb->prefix . 'syn_products';
    parse_str($_POST['data'], $data);

    $row = [
        'external_id'        => sanitize_text_field($data['external_id']),
        'name'        => sanitize_text_field($data['name']),
        'category'    => sanitize_text_field($data['category']),
        'price'       => floatval($data['price']),
        'description' => sanitize_textarea_field($data['description']),
        'content' => sanitize_textarea_field($data['content']),
        'updated_at'  => current_time('mysql'),
    ];

    if (!empty($data['id'])) {
        $wpdb->update($table, $row, ['id' => intval($data['id'])]);
        $id = intval($data['id']);
        $action = 'update';
    } else {
        $wpdb->insert($table, $row);
        $id = $wpdb->insert_id;
        $action = 'insert';
    }

    if (function_exists('sync_to_sheets')) {
        sync_to_sheets();
    }

    wp_send_json_success([
        'message' => $action === 'insert' ? 'Đã thêm sản phẩm mới!' : 'Đã cập nhật sản phẩm!',
        'action'  => $action,
        'id'      => $id,
        'row'     => array_merge(['id' => $id], $row)
    ]);
});


add_action('wp_ajax_sync_delete_product', function () {
    check_ajax_referer('sync_delete_nonce');

    if (empty($_POST['id'])) {
        wp_send_json_error(['message' => 'Thiếu ID sản phẩm cần xóa']);
    }

    global $wpdb;
    $table = $wpdb->prefix . 'syn_products';
    $id = intval($_POST['id']);

    $deleted = $wpdb->delete($table, ['id' => $id], ['%d']);

    if (!$deleted) {
        wp_send_json_error(['message' => 'Không thể xóa sản phẩm (có thể ID không tồn tại)']);
    }

    $res = sync_to_sheets();
    if (!empty($res['error'])) {
        wp_send_json_error(['message' => 'Đã xóa sản phẩm nhưng lỗi khi đồng bộ Sheet: ' . $res['error']]);
    }

    wp_send_json_success([
        'message' => ' Đã xóa sản phẩm và đồng bộ Google Sheet thành công',
        'sync_result' => $res
    ]);
});
