<?php
class Tracking_Controller extends WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'wp/v1';
        $this->rest_base = 'track';
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)', // (?P<id>\d+) là biểu thức Regex để bắt ID
            array(
                array(
                    'methods'             => WP_REST_Server::CREATABLE, // POST
                    'callback'            => array( $this, 'track_post_view' ),
                    'permission_callback' => '__return_true', // Cho phép truy cập công khai
                    'args'                => array(
                        // Tham số tùy chọn để tắt kiểm tra IP. E.g., ?check_ip=0
                        'check_ip' => array(
                            'required'          => false,
                            'type'              => 'boolean',
                            'default'           => true, // Mặc định là BẬT kiểm tra IP
                        ),
                    ),
                ),
                // ✨ HÀM GET ĐƯỢC THÊM VÀO ✨
                array(
                    'methods'             => WP_REST_Server::READABLE, // GET
                    'callback'            => array( $this, 'get_post_view' ),
                    'permission_callback' => '__return_true', // Cho phép truy cập công khai
                ),
            )
        );
    }

    /**
     * Hàm Callback chính: Xử lý logic theo dõi lượt xem (Sử dụng post_meta).
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function track_post_view( $request ) {
        
        // Lấy tham số từ $request
        $post_id    = (int) $request['id'];
        $check_ip   = (bool) $request->get_param('check_ip');
        $time_limit_seconds = 1800; // 30 phút

        // Kiểm tra xem bài viết có tồn tại không
        if ( empty($post_id) || get_post_type($post_id) === false ) {
            return new WP_REST_Response(['message' => 'ID bài viết không hợp lệ.'], 404);
        }

        $ip_address = $this->get_user_ip();
        $count_key = 'post_views_count'; 
        $last_view_meta_key = '_post_view_last_time_'; 
        
        if ( $check_ip ) {
            $ip_hash = md5($ip_address); // mã hóa IP
            $last_view_meta_key .= $ip_hash;
        } else {
            $last_view_meta_key .= 'global';
        }

        // Lấy thời điểm xem cuối cùng (dựa trên IP hoặc global)
        $last_view = (int) get_post_meta($post_id, $last_view_meta_key, true);
        $current_time = time();
        
        $can_increment = false;
        if ( !$last_view || ($current_time - $last_view) > $time_limit_seconds ) {
            $can_increment = true;
        }

        
        $views = (int) get_post_meta($post_id, $count_key, true);

        if ( $can_increment ) {
            $new_views = $views + 1;

            update_post_meta($post_id, $count_key, $new_views);
            // Cập nhật thời gian xem cuối cùng cho key (IP hoặc global)
            update_post_meta($post_id, $last_view_meta_key, $current_time);

            return new WP_REST_Response([
                'message'       => 'Lượt xem đã được cập nhật.',
                'total_views'   => $new_views,
                'ip_checked'    => $check_ip,
            ], 200);
            
        } else {
            // Đã xem trong vòng 30 phút, không tăng viewd
            return new WP_REST_Response([
                'message'       => 'Quá sớm để tăng lượt xem (dưới 30 phút).',
                'total_views'   => $views, 
                'ip_checked'    => $check_ip,
            ], 200);
        }
    }
    public function get_post_view( $request ) {
        $post_id    = (int) $request['id'];
        $count_key = 'post_views_count';

        if ( empty($post_id) || get_post_type($post_id) === false ) {
            return new WP_REST_Response(['message' => 'ID bài viết không hợp lệ.'], 404);
        }

        // Lấy tổng lượt xem hiện tại
        $views = (int) get_post_meta($post_id, $count_key, true);

        return new WP_REST_Response([
            'status'        => 'success',
            'post_id'       => $post_id,
            'total_views'   => $views
        ], 200);
    }

    private function get_user_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }
        $ip = explode(',', $ip)[0];
        return sanitize_text_field(trim($ip));
    }
}


