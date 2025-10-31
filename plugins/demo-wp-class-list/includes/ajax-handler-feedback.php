
<?php
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';

//Export excel
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;

add_action('wp_ajax_export_feedback_excel', function () {
    if (
        empty($_GET['_ajax_nonce_excel_feedback']) ||
        !wp_verify_nonce($_GET['_ajax_nonce_excel_feedback'], 'exportExcel_feedback_nonce')
    ) {
        wp_die('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
        wp_die("Bạn không có quyền thực hiện thao tác này.", 403);
    }

    global $wpdb;
    $table = 'wp_user_feedbacks';
    $rows = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_A);
    if (!$rows) {
        wp_die('Không có dữ liệu để xuất.');
    }

    try {
        $writer = new Writer();
        $writer->openToBrowser('danh-sach-feedback.xlsx');

        //  Tạo style cho header
        $headerStyle = new Style();
        $headerStyle->setFontBold();

        //  Header row
        $headers = ['ID', 'Tên', 'Bình luận', 'Đánh giá ', 'Ngày đánh giá'];
        $writer->addRow(Row::fromValues($headers, $headerStyle));

        //  Ghi dữ liệu
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues([
                $row['id'] ,
                $row['name'] ,
                $row['message'] ,
                $row['rating'] ,
                $row['created_at'] 
            ]));
        }

        //  Đóng file
        $writer->close();
        exit;
    } catch (Exception $e) {
        error_log('LỖI XUẤT EXCEL: ' . $e->getMessage());
        wp_die('Lỗi xuất file. Vui lòng kiểm tra log hệ thống.');
    }
});






add_action('wp_ajax_approve_feedback', function () {
    check_ajax_referer('feedback_actions_nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Không có quyền duyệt.']);
    }

    global $wpdb;
    $id = intval($_POST['id']);
    $table = 'wp_user_feedbacks';

    $updated = $wpdb->update($table, ['status' => 1], ['id' => $id]);

    if ($updated !== false) {
        wp_send_json_success(['message' => 'Đã duyệt feedback ID ' . $id]);
    } else {
        wp_send_json_error(['message' => 'Không thể cập nhật feedback.']);
    }
});

add_action('wp_ajax_delete_feedback', function () {
    check_ajax_referer('feedback_actions_nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Không có quyền xoá.']);
    }

    global $wpdb;
    $id = intval($_POST['id']);
    $table ='wp_user_feedbacks';

    $deleted = $wpdb->delete($table, ['id' => $id]);

    if ($deleted) {
        wp_send_json_success(['message' => 'Đã xoá feedback ID ' . $id]);
    } else {
        wp_send_json_error(['message' => 'Không thể xoá feedback.']);
    }
});