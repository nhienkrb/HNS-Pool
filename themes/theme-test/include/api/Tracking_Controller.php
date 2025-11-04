<?php
class Tracking_Controller extends WP_REST_Controller
{
    protected $table_name;
    const TIME_LIMIT_SECONDS = 1800; // 30 phút

    public function __construct()
    {
        global $wpdb;
        $this->namespace = 'wp/v1';
        $this->rest_base = 'track';
        $this->table_name = $wpdb->prefix . 'post_view';
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => [$this, 'track_post_view'],
                    'permission_callback' => '__return_true',
                    'args'                => [
                        'check_ip' => [
                            'type'    => 'boolean',
                            'default' => true,
                        ],
                    ],
                ],
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [$this, 'get_post_view'],
                    'permission_callback' => '__return_true',
                ],
            ]
        );
    }

    /**
     * Ghi nhận lượt xem bài viết
     */
    public function track_post_view($request)
    {
        global $wpdb;
        $post_id    = (int) $request['id'];
        $check_ip   = (bool) $request->get_param('check_ip');
        $ip_address = $this->get_user_ip();
        $now        = time();
        $can_increment = false;

        if (empty($post_id) || get_post_type($post_id) === false) {
            return new WP_REST_Response(['message' => 'ID bài viết không hợp lệ.'], 404);
        }

        // Kiểm tra lần xem gần nhất
        if ($check_ip) {
            $row = $wpdb->get_row($wpdb->prepare("
                SELECT last_view FROM {$this->table_name}
                WHERE post_id = %d AND ip_address = %s
                ORDER BY id DESC LIMIT 1
            ", $post_id, $ip_address));
        } else {
            $row = $wpdb->get_row($wpdb->prepare("
                SELECT last_view FROM {$this->table_name}
                WHERE post_id = %d
                ORDER BY id DESC LIMIT 1
            ", $post_id));
        }

        if ($row) {
            $diff = $now - intval($row->last_view);
            if ($diff > self::TIME_LIMIT_SECONDS) {
                $can_increment = true; // Đã quá 30 phút
            }
        } else {
            $can_increment = true; // Chưa có lượt xem nào
        }

        // Nếu đủ điều kiện  thêm lượt xem
        if ($can_increment) {
            $wpdb->insert(
                $this->table_name,
                [
                    'post_id'    => $post_id,
                    'ip_address' => $check_ip ? $ip_address : null,
                    'last_view'  => $now,
                    'created_at' => current_time('mysql'),
                ],
                ['%d', '%s', '%d', '%s']
            );

            $total_views = $this->get_total_post_views($post_id);

            return new WP_REST_Response([
                'status'      => 'success',
                'message'     => 'Lượt xem đã được cập nhật.',
                'total_views' => $total_views,
                'ip_checked'  => $check_ip,
            ], 201);
        }

        return new WP_REST_Response([
            'status'      => 'skip',
            'message'     => 'Chưa đến 30 phút, không tăng lượt xem.',
            'total_views' => $this->get_total_post_views($post_id),
            'ip_checked'  => $check_ip,
        ], 200);
    }

    /**
     * Lấy tổng lượt xem bài viết
     */
    public function get_post_view($request)
    {
        $post_id = (int) $request['id'];

        if (empty($post_id) || get_post_type($post_id) === false) {
            return new WP_REST_Response(['message' => 'ID bài viết không hợp lệ.'], 404);
        }

        $views = $this->get_total_post_views($post_id);

        return new WP_REST_Response([
            'status'      => 'success',
            'post_id'     => $post_id,
            'total_views' => $views,
        ], 200);
    }

    /**
     * Đếm tổng lượt xem 
     */
    private function get_total_post_views($post_id)
    {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(*) FROM {$this->table_name} WHERE post_id = %d
        ", $post_id));
        return (int) $count;
    }

    /**
     * Lấy IP người dùng (IPv4 / IPv6)
     */
    private function get_user_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        $ip = explode(',', $ip)[0];
        $ip = trim($ip);

        // Chuyển IP sang dạng nhị phân
        $binary_ip = @inet_pton($ip);
        return $binary_ip !== false ? $binary_ip : null;
    }
}
