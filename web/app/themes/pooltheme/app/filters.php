<?php

/**
 * Theme filters.
 */

namespace App;
$filter_files = glob(__DIR__ . '/filters/*.php');

foreach ($filter_files as $file) {
    require $file;
}

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

