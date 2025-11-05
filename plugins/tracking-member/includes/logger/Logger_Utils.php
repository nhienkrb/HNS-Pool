<?php
class Logger_Utils
{
    public static function get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        $ip = trim($ip);
        $binary_ip = @inet_pton($ip);

        return $binary_ip !== false ? $binary_ip : inet_pton('0.0.0.0');
    }

    public static function get_user_info($user_id)
    {
        $user = get_user_by('ID', $user_id);
        if (!$user) return null;

        return [
            'user_id' => $user_id,
            'name'    => $user->display_name,
            'email'   => $user->user_email,
            'role'    => current($user->roles),
        ];
    }
}
