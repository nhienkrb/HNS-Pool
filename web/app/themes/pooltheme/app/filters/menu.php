<?php

add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if ($args->theme_location === 'primary_navigation') {
        $classes[] = 'menu-item';
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if ($args->theme_location === 'primary_navigation') {
        $atts['class'] = 'text-white !no-underline';
    }
    return $atts;
}, 10, 3);
