<?php
add_action('wp_ajax_submit_feedback', 'handle_submit_feedback');
add_action('wp_ajax_nopriv_submit_feedback', 'handle_submit_feedback');
add_action('wp_ajax_get_post_average_rating', 'ajax_get_post_average_rating');
add_action('wp_ajax_nopriv_get_post_average_rating', 'ajax_get_post_average_rating');

function handle_submit_feedback()
{
    check_ajax_referer('submit_feedback_nonce');

    global $wpdb;
    $table = $wpdb->prefix . 'user_feedbacks';

    $data = [
        'post_id' => intval($_POST['post_id']),
        'name'    => sanitize_text_field($_POST['name']),
        'message' => sanitize_textarea_field($_POST['message']),
        'rating'  => intval($_POST['rating']),
        'status'  => 0,
    ];

    if (empty($data['name']) || empty($data['message'])) {
        wp_send_json_error(['message' => 'Vui lòng nhập đầy đủ thông tin.']);
    }

    $inserted = $wpdb->insert($table, $data);

    if ($inserted) {
        wp_send_json_success(['message' => 'Gửi thành công, đang chờ duyệt!']);
    } else {
        wp_send_json_error(['message' => 'Không thể lưu feedback.']);
    }
}



function ajax_get_post_average_rating()
{
    check_ajax_referer('get_post_average_rating_nonce');

    global $wpdb;
    $post_id = intval($_POST['post_id']);

    if (!$post_id) {
        wp_send_json_error(['message' => 'Thiếu ID bài viết']);
    }

    $table = $wpdb->prefix . 'user_feedbacks';

    $avg = $wpdb->get_var($wpdb->prepare("
        SELECT AVG(rating) FROM {$table} 
        WHERE post_id = %d AND status = 1
    ", $post_id));

    $avg = $avg ? round($avg, 1) : 0;
    $full_stars = floor($avg);
    $has_half = ($avg - $full_stars) >= 0.5;

    $full = '<svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 576 512" fill="#facc15"><path d="M259.3 17.8L194 150.2 47.9 171.5C10.7 176.6-10.7 219.8 12.3 249.3l105.7 103L93.8 470c-7.9 46.1 40.6 81 82.4 59.3L288 405.3l111.8 58.7c41.8 21.8 90.3-13.2 82.4-59.3l-24.2-117.7 105.7-103c23-29.5 1.6-72.7-35.6-77.8L382 150.2 316.7 17.8C301.9-5.9 274.1-5.9 259.3 17.8z"/></svg>';
    $empty = '<svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 576 512" fill="#e5e7eb"><path d="M528.1 171.5L382 150.2 316.7 17.8C307.5 1.5 288.5 1.5 279.3 17.8L214 150.2 67.9 171.5C47 174.5 37.8 197.6 52.9 211l105.7 103L133.8 470c-3.6 21 18.5 37 37 27.1L288 405.3l117.2 61.7c18.5 9.8 40.6-6.1 37-27.1l-24.8-155.9 105.7-103c15.1-13.4 5.9-36.5-15-39.5zM388.6 312.3l18.5 108.1L288 385.4 168.9 420.4l18.5-108.1L112 246.4l108.3-15.7 48.5-98.4 48.5 98.4 108.3 15.7-78.8 65.9z"/></svg>';
    $half = '<svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 576 512"><defs><linearGradient id="half"><stop offset="50%" stop-color="#facc15"/><stop offset="50%" stop-color="#e5e7eb"/></linearGradient></defs><path fill="url(#half)" d="M259.3 17.8L194 150.2 47.9 171.5C10.7 176.6-10.7 219.8 12.3 249.3l105.7 103L93.8 470c-7.9 46.1 40.6 81 82.4 59.3L288 405.3l111.8 58.7c41.8 21.8 90.3-13.2 82.4-59.3l-24.2-117.7 105.7-103c23-29.5 1.6-72.7-35.6-77.8L382 150.2 316.7 17.8C301.9-5.9 274.1-5.9 259.3 17.8z"/></svg>';

    $stars_html = '';
    for ($i = 0; $i < $full_stars; $i++) $stars_html .= $full;
    if ($has_half) $stars_html .= $half;
    for ($i = $full_stars + ($has_half ? 1 : 0); $i < 5; $i++) $stars_html .= $empty;

    $html = "<div><p>Đánh giá trung bình</p>
{$stars_html}<br><small>Trung bình: {$avg} / 5</small></div>";

    wp_send_json_success(['html' => $html]);
}
