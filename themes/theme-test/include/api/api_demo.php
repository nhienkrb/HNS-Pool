<?php
require_once get_template_directory() . '/include/api/Tracking_Controller.php';

add_action('rest_api_init', function () {
    $controller = new Tracking_Controller();
    $controller->register_routes();
});
