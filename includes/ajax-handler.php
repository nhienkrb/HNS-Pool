<?php
add_action('wp_ajax_save_member', function () {
    check_ajax_referer('member_nonce');

    global $wpdb;
    parse_str($_POST['data'], $data);

    $table ='shop_member';

    $item = [
        'name'      => sanitize_text_field($data['name']),
        'sdt'       => sanitize_text_field($data['sdt']),
        'dia_chi'   => sanitize_text_field($data['dia_chi']),
        'gioi_tinh' => intval($data['gioi_tinh'])
    ];

    if (!empty($data['ID'])) {
        $wpdb->update($table, $item, ['ID' => intval($data['ID'])]);
        wp_send_json_success("Đã cập nhật thành viên!");
    } else {
        $wpdb->insert($table, $item);
        wp_send_json_success("Đã thêm thành viên mới!");
    }
});

add_action('wp_ajax_delete_member', function () {
    check_ajax_referer('member_nonce');
    global $wpdb;
    $id = intval($_POST['id']);
    $wpdb->delete( 'shop_member', ['ID' => $id]);
    wp_send_json_success("Đã xóa thành viên!");
});
