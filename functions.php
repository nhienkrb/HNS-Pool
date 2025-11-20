<?php

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/custom-post-type.php';
require_once get_template_directory() . '/inc/Helpers.php';
require_once get_template_directory() . '/inc/Queries.php';
require_once get_template_directory() . '/inc/Queries.php';
require_once get_template_directory() . '/inc/customize.php';
require_once get_template_directory() . '/inc/Breadcrumbs.php';


add_filter('script_loader_tag', function ($tag, $handle, $src) {

    if ($handle === 'vite-app' || $handle === 'vite-client') {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}, 10, 3);;

