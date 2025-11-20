<?php
function theme_pool_enqueue()
{

    if (theme_pool_is_dev()) {

        wp_enqueue_script(
            'vite-client',
            'http://localhost:5173/@vite/client',
            [],
            null,
            true
        );

        wp_enqueue_script(
            'vite-app',
            'http://localhost:5173/assets/js/app.js',
            [],
            null,
            [
                'type' => 'module',
                'strategy' => 'defer'
            ]
        );
        return;
    }
}
add_action('wp_enqueue_scripts', 'theme_pool_enqueue');

function theme_pool_is_dev()
{
    $response = wp_remote_get("http://localhost:5173");
    return !is_wp_error($response);
}
