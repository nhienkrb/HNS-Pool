<?php
add_action('wp_login', 'logger_log_user_login', 10, 1);
add_action('wp_logout', 'logger_log_user_logout');
add_action('save_post', 'logger_log_post_save', 10, 2);
add_action('before_delete_post', 'logger_log_post_delete');

function logger_log_user_login($user)
{
    $user_id = get_current_user_id();
    logger_insert_log($user_id, 'user_login', 'user_login');
}


function logger_log_user_logout()
{
    $user_id = get_current_user_id();
    if ($user_id) {
        logger_insert_log($user_id, 'user_logout',  'user_logout');
    }
}


function logger_log_post_save($post, $update)
{
    if (!in_array($post->post_type, ['post', 'page'])) return;

    $user_id = get_current_user_id();
    if (!$user_id) return;

    $action = $update ? 'updated' : 'created';
    logger_insert_log($user_id, "{$post->post_type}_{$action}", $post->post_type);
}

function logger_log_post_delete($post_id)
{
    $post = get_post($post_id);
    if (!$post || !in_array($post->post_type, ['post', 'page'])) return;

    $user_id = get_current_user_id();
    if (!$user_id) return;

    logger_insert_log($user_id, "{$post->post_type}_deleted", $post->post_type);
}


function logger_insert_log($user_id, $action_name = '')
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_action_logger';

    $user = get_user_by('ID', $user_id);
    $ip_address = logger_get_client_ip_address();
    $wpdb->insert(
        $table_name,
        [
            'name'         => $user->display_name,
            'email'        => $user->user_email,
            'role'         => current($user->roles),
            'action_name'  => $action_name,
            'ip_address'   => $ip_address,
            'date'         => current_time('mysql'),
            'user_id'  => $user->ID,
        ],
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        ]
    );
}


function logger_get_client_ip_address()
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
