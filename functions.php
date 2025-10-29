<?php

function myTheme_enqueue_styles()
{
    // css
    wp_enqueue_style('theme-css', get_template_directory_uri() . "/assets/css/my.css");
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // js
    wp_enqueue_script('theme-js', get_template_directory_uri() . "/assets/js/js-theme.js", array('jquery'), '1.0', true);
    wp_localize_script(
        'theme-js',
        'myAjax',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'), // Đường dẫn AJAX  của WP
             'home_url' => home_url()
        )
    );
    wp_enqueue_script('webcamjs', get_template_directory_uri() . "/assets/js/webcam.min.js" , [], null, true);
    wp_enqueue_script('signature_pad', get_template_directory_uri() . "/assets/js/signature_pad.min.js", [], null, true);
};




function handle_checkin_data_callback()
{
    global $wpdb;


    // 2. Lấy dữ liệu đã gửi từ AJAX
    $bib_photo_base64 = wp_kses_post($_POST['image']); // Dùng wp_kses_post cho chuỗi dài
    $signature_base64 = wp_kses_post($_POST['signature']);
    $member_id = intval($_POST['member_id'] ?? 1);
    // 3. Chuẩn bị dữ liệu và tên bảng (shop_member)
    $table_name = 'shop_member';
    // Nếu bạn dùng tên bảng không có prefix của WP, bạn cần đảm bảo nó tồn tại

    $data_to_insert = array(
        'bib_photo'      => $bib_photo_base64,
        'signature_data' => $signature_base64,
    );



    // 4. Thực hiện lệnh update
    $inserted = $wpdb->update(
        $table_name,
        $data_to_insert,
        ['ID' => $member_id],          // Điều kiện WHERE
        array('%s', '%s'), // Định dạng dữ liệu (String)
        array('%d') // Định dạng cho WHERE: ID là số nguyên (%d)
    );

    if ($inserted !== false && $inserted > 0) {
        wp_send_json_success(array('updated_rows' => $inserted, 'message' => 'Cập nhật Check-in thành công!'));
    } elseif ($inserted === 0) {
        wp_send_json_success(array('updated_rows' => 0, 'message' => 'Không có dữ liệu mới để cập nhật.'));
    } else {
        wp_send_json_error($wpdb->last_error);
    }

    wp_die();
}


function get_checkin_members_callback() {
    global $wpdb;
    $table_name = 'shop_member'; 
    
    $members = $wpdb->get_results( 
        "SELECT ID, name, sdt, dia_chi, gioi_tinh, bib_photo,signature_data
         FROM $table_name 
         ORDER BY id ASC 
         LIMIT 10", 
        ARRAY_A 
    );

    if ( $members ) {
        wp_send_json_success( $members );
    } else {
        wp_send_json_error( 'Không tìm thấy thành viên nào trong danh sách.' );
    }

    wp_die();
}

add_action('template_redirect', function() {
    // Nếu không có ?member_id thì load trang table
    if (!isset($_GET['member_id'])) {
        include get_template_directory() . '/display_view_table.php';
        exit;
    }
});

function get_member_detail_checkin_callback() {
    global $wpdb;
    $member_id = intval($_POST['member_id']);

    if (!$member_id) {
        wp_send_json_error("Thiếu ID thành viên.");
    }

    $table = 'shop_member';
    $member = $wpdb->get_row(
        $wpdb->prepare("SELECT bib_photo, signature_data FROM $table WHERE ID = %d", $member_id),
        ARRAY_A
    );

    if ($member) {
        wp_send_json_success($member);
    } else {
        wp_send_json_error("Không tìm thấy thành viên.");
    }

    wp_die();
}

add_action('wp_ajax_get_member_detail_checkin', 'get_member_detail_checkin_callback');
add_action( 'wp_ajax_get_checkin_members', 'get_checkin_members_callback' ); 
add_action('wp_ajax_handle_checkin_data', 'handle_checkin_data_callback');
add_action('wp_enqueue_scripts', 'myTheme_enqueue_styles');
