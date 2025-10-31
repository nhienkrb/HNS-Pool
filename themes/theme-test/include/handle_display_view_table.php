<?php
//  Thêm chữ ký vào PDF


require_once get_template_directory() . '/vendor/autoload.php';

use setasign\Fpdi\Fpdi;




function handle_checkin_data_callback()
{
    global $wpdb;


    // 2. Lấy dữ liệu đã gửi từ AJAX
    $bib_photo_base64 = wp_kses_post($_POST['image']); // Dùng wp_kses_post cho chuỗi dài
    $signature_base64 = wp_kses_post($_POST['signature']);
    $member_id = intval($_POST['member_id'] ?? 1);
    // 3. Chuẩn bị dữ liệu và tên bảng (shop_member)
    $table_name = 'shop_member';

    // === Tạo thư mục lưu file ===
    $upload_dir = wp_upload_dir();
    $checkin_dir = $upload_dir['basedir'] . '/checkin_pdfs/';
    $checkin_url = $upload_dir['baseurl'] . '/checkin_pdfs/';
    if (!file_exists($checkin_dir)) wp_mkdir_p($checkin_dir);

    // === Lưu file chữ ký (ảnh PNG) ===
    $signature_path = $checkin_dir . "signature_{$member_id}.png";
    $signature_data = explode(',', $signature_base64);
    file_put_contents($signature_path, base64_decode($signature_data[1]));

    // === Nạp file PDF template ===
    $template_pdf = get_template_directory() . '/pdf_templates/sample.pdf';
    $output_pdf = $checkin_dir . "checkin_member_{$member_id}.pdf";

    $pdf = new Fpdi();
    $pdf->AddPage();
    $pageCount = $pdf->setSourceFile($template_pdf);
    $tpl = $pdf->importPage(1);
    $pdf->useTemplate($tpl, 0, 0, 210);

    // --- Chèn chữ ký vào vị trí (x, y)
    $pdf->Image($signature_path, 140, 250, 40, 20);
    $pdf->Output($output_pdf, 'F');

    $pdf_url = $checkin_url . "checkin_member_{$member_id}.pdf";

    $data_to_insert = array(
        'bib_photo'      => $bib_photo_base64,
        'signature_data' => $signature_base64,
        'pdf_path' => $pdf_url,
    );

    // 4. Thực hiện lệnh update
    $inserted = $wpdb->update(
        $table_name,
        $data_to_insert,
        ['ID' => $member_id],          // Điều kiện WHERE
        array('%s', '%s'), // Định dạng dữ liệu (String)
        array('%d') // Định dạng cho WHERE: ID là số nguyên (%d)
    );
    // === Gửi email cho member ===
    $member = $wpdb->get_row($wpdb->prepare("SELECT * FROM shop_member WHERE ID = %d", $member_id));
    if ($member && $member->email) {
        $to = $member->email;
        $subject = "Xác nhận Check-in thành công";
        $message = "Xin chào {$member->name},<br><br>
        Check-in của bạn đã hoàn tất.<br>
        Bạn có thể xem file PDF chữ ký tại đây:<br>
        <a href='{$pdf_url}'>{$pdf_url}</a>";
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        wp_mail($to, $subject, $message, $headers);
    }
    if ($inserted !== false && $inserted > 0) {
        wp_send_json_success(array('updated_rows' => $inserted, 'message' => 'Cập nhật Check-in thành công!'));
    } elseif ($inserted === 0) {
        wp_send_json_success(array('updated_rows' => 0, 'message' => 'Không có dữ liệu mới để cập nhật.'));
    } else {
        wp_send_json_error($wpdb->last_error);
    }
    wp_die();
}


function gmail_smtp_config($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.gmail.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 587;
    $phpmailer->Username   = 'nhiennkrb@gmail.com';
    $phpmailer->Password   = 'csfyeczcrfmqvhsv';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From       = 'nhiennkrb@gmail.com';
    $phpmailer->FromName   = 'Shop Check-in System';

    $phpmailer->SMTPDebug = 2;
    $phpmailer->Debugoutput = function ($str, $level) {
        file_put_contents(WP_CONTENT_DIR . '/smtp-debug.log', date('H:i:s') . " $str\n", FILE_APPEND);
    };
}
add_action('phpmailer_init', 'gmail_smtp_config');


add_action('init', function () {
    if (isset($_GET['send_test_mail'])) {
        $to = 'ngonhien3103@gmail.com';
        $subject = '🔔 Test Gmail SMTP from WordPress';
        $message = 'Nếu bạn nhận được email này, Gmail SMTP hoạt động OK 🎉';
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        if (wp_mail($to, $subject, $message, $headers)) {
            echo 'Gửi mail thành công!';
        } else {
            echo 'Gửi mail thất bại!';
        }
        exit;
    }
});




function get_checkin_members_callback()
{
    global $wpdb;
    $table_name = 'shop_member';

    $members = $wpdb->get_results(
        "SELECT ID, name, sdt, dia_chi, gioi_tinh, bib_photo,signature_data
         FROM $table_name 
         ORDER BY id ASC 
         LIMIT 10",
        ARRAY_A
    );

    if ($members) {
        wp_send_json_success($members);
    } else {
        wp_send_json_error('Không tìm thấy thành viên nào trong danh sách.');
    }

    wp_die();
}

// add_action('template_redirect', function () {
//     // Nếu không có ?member_id thì load trang table
//     if (!isset($_GET['member_id'])) {
//         include get_template_directory() . '/display_view_table.php';
//         exit;
//     }
// });

function get_member_detail_checkin_callback()
{
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
add_action('wp_ajax_get_checkin_members', 'get_checkin_members_callback');
add_action('wp_ajax_handle_checkin_data', 'handle_checkin_data_callback');
add_action('wp_enqueue_scripts', 'myTheme_enqueue_styles');
