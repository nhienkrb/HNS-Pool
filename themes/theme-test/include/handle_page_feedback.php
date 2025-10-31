<?php
add_action('wp_ajax_submit_feedback', 'handle_submit_feedback');
add_action('wp_ajax_nopriv_submit_feedback', 'handle_submit_feedback');

function handle_submit_feedback()
{
    check_ajax_referer('submit_feedback_nonce');

    global $wpdb;

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $rating  = intval($_POST['rating'] ?? 5);

    if (empty($name) || empty($message)) {
        wp_send_json_error(['message' => 'Vui lòng nhập đầy đủ thông tin.']);
    }

    $wpdb->insert('wp_user_feedbacks', [
        'name' => $name,
        'message' => $message,
        'rating' => $rating,
        'status' => 'pending',
        'created_at' => current_time('mysql'),
    ]);

    wp_send_json_success(['message' => 'Feedback đã được gửi. Cảm ơn bạn!']);
};
