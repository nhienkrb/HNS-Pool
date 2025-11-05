<?php
class Logger_Auth
{
    public function __construct()
    {
        add_action('wp_login', [$this, 'on_login'], 10, 2);
        add_action('wp_logout', [$this, 'on_logout']);
        add_action('wp_login_failed', [$this, 'on_login_failed']);
    }
    public function on_login($user_login, $user)
    {
        if (!($user instanceof WP_User)) {
            error_log('on_login: user không hợp lệ');
            return;
        }
        error_log('Login thành công: ' . $user->user_login . ' (ID: ' . $user->ID . ')');
        Logger_DB::insert($user->ID, 'login');
    }


    public function on_logout()
    {
        $user_id = get_current_user_id();
        if ($user_id) {
            Logger_DB::insert($user_id, 'logout');
            error_log("User {$user_id} đã đăng xuất");
        }
    }
    public function on_login_failed($username)
    {
        error_log(" Đăng nhập thất bại cho username: {$username}");
    }
}
