<?php
namespace StoryMgr\Auth;

final class Auth {
    public static function handleRegister(): void {
        $nonce = isset($_POST['storymgr_nonce']) ? sanitize_text_field(wp_unslash($_POST['storymgr_nonce'])) : '';
        if (!wp_verify_nonce($nonce, 'storymgr_register')) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        $userLogin = isset($_POST['user_login']) ? sanitize_user(wp_unslash($_POST['user_login'])) : '';
        $userEmail = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
        $userPass  = isset($_POST['user_pass']) ? (string) wp_unslash($_POST['user_pass']) : '';
        $redirect  = isset($_POST['_redirect']) ? esc_url_raw(wp_unslash($_POST['_redirect'])) : '';

        if ($userLogin === '' || $userEmail === '' || $userPass === '') {
            self::registerRedirectWithError('missing_fields', $redirect);
        }

        if (!is_email($userEmail)) {
            self::registerRedirectWithError('invalid_email', $redirect);
        }

        if (username_exists($userLogin)) {
            self::registerRedirectWithError('username_exists', $redirect);
        }

        if (email_exists($userEmail)) {
            self::registerRedirectWithError('email_exists', $redirect);
        }

        $userId = wp_create_user($userLogin, $userPass, $userEmail);
        if (is_wp_error($userId)) {
            self::registerRedirectWithError('create_failed', $redirect);
        }

        $user = get_user_by('id', $userId);
        if ($user) {
            $user->set_role('subscriber');
        }

        $creds = [
            'user_login'    => $userLogin,
            'user_password' => $userPass,
            'remember'      => true,
        ];
        wp_signon($creds, false);

        wp_safe_redirect($redirect ? $redirect : home_url('/'));
        exit;
    }

    private static function registerRedirectWithError(string $code, string $redirect = ''): void {
        $url = $redirect ? $redirect : home_url('/dang-ky/');
        $url = add_query_arg(['storymgr_register_error' => $code], $url);
        wp_safe_redirect($url);
        exit;
    }

    public static function getAccountUrl(): string {
        return (string) apply_filters('storymgr_account_url', home_url('/tai-khoan/'));
    }

    public static function blockWpAdmin(): void {
        if (!is_admin()) return;
        if (wp_doing_ajax()) return;

        $pagenow = isset($GLOBALS['pagenow']) ? $GLOBALS['pagenow'] : '';
        if ($pagenow === 'admin-post.php') {
            $action = isset($_REQUEST['action']) ? sanitize_text_field(wp_unslash($_REQUEST['action'])) : '';
            $allowed = ['storymgr_register', 'storymgr_toggle_favorite'];
            if (in_array($action, $allowed, true)) {
                return;
            }
        }

        if (!current_user_can('manage_options')) {
            wp_safe_redirect(self::getAccountUrl());
            exit;
        }
    }
}
