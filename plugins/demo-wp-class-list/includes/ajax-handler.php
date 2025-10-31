
<?php
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';

// Lớp cho QR Code (Endroid)
use Endroid\QrCode\Color\Color; // Đổi tên Color để tránh xung đột với Spout\Color
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;


add_action('wp_ajax_save_member', function () {
    check_ajax_referer('member_nonce');
    global $wpdb;

    parse_str($_POST['data'], $data);
    $table = 'shop_member';

    $item = [
        'name'      => sanitize_text_field($data['name']),
        'sdt'       => sanitize_text_field($data['sdt']),
        'dia_chi'   => sanitize_text_field($data['dia_chi']),
        'gioi_tinh' => intval($data['gioi_tinh']),
    ];

    //  Nếu là cập nhật
    if (!empty($data['ID'])) {
        $wpdb->update($table, $item, ['ID' => intval($data['ID'])]);
        wp_send_json_success("Đã cập nhật thành viên!");
        return;
    }

    $uuid = wp_generate_uuid4();
    $upload_dir = wp_upload_dir();
    $qr_dir = trailingslashit($upload_dir['basedir']) . 'qrcodes/';
    $qr_url = trailingslashit($upload_dir['baseurl']) . 'qrcodes/';

    if (!file_exists($qr_dir)) {
        wp_mkdir_p($qr_dir);
    }

    $qrCode = new QrCode(
        data: $uuid,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );

    $label = new Label(
        text: 'Member QR',
        textColor: new Color(255, 0, 0)
    );

    $writer = new PngWriter();
    $result = $writer->write($qrCode, null, $label);

    //  Lưu QR file (tên file theo UUID)
    $filename = 'member-' . $uuid . '.png';
    $file_path = $qr_dir . $filename;
    $result->saveToFile($file_path);

    $item['key_uuid'] = $uuid;
    $item['path_QR'] = $qr_url . $filename;
    $wpdb->insert($table, $item);

    wp_send_json_success($item['path_QR']);
});


add_action('wp_ajax_delete_member', function () {
    check_ajax_referer('member_nonce');
    global $wpdb;
    $id = intval($_POST['id']);
    $wpdb->delete('shop_member', ['ID' => $id]);
    wp_send_json_success("Đã xóa thành viên!");
});


//Export excel
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;

add_action('wp_ajax_export_members_excel', function () {
    if (empty($_GET['_ajax_nonce']) || !wp_verify_nonce($_GET['_ajax_nonce'], 'member_nonce')) {
        wp_die('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
        wp_die("Bạn không có quyền thực hiện thao tác này.", 403);
    }

    global $wpdb;
    $table = 'shop_member';
    $rows = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_A);

    if (!$rows) {
        wp_die('Không có dữ liệu để xuất.');
    }

    try {
        $writer = new Writer();
        $writer->openToBrowser('danh-sach-thanh-vien.xlsx');

        //  Tạo style cho header
        $headerStyle = new Style();
        $headerStyle->setFontBold();

        //  Header row
        $headers = ['ID', 'Tên', 'SĐT', 'Địa chỉ', 'Giới tính', 'UUID', 'Đường dẫn QR'];
        $writer->addRow(Row::fromValues($headers, $headerStyle));

        //  Ghi dữ liệu
        foreach ($rows as $row) {
            $genderText = $row['gioi_tinh'] == 1 ? 'Nam' : ($row['gioi_tinh'] == 0 ? 'Nữ' : 'Khác');
            $writer->addRow(Row::fromValues([
                $row['ID'],
                $row['name'],
                $row['sdt'],
                $row['dia_chi'],
                $genderText,
                $row['key_uuid'] ?? '',
                $row['path_QR'] ?? ''
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
