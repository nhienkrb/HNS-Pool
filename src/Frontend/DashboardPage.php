<?php
namespace StoryMgr\Frontend;

use StoryMgr\Shortcodes\Shortcodes;

final class DashboardPage {
    public static function renderIfDashboard(string $content): string {
        if (is_admin()) return $content;
        if (!is_page()) return $content;

        $post = get_post();
        if (!$post) return $content;

        $slug = (string) apply_filters('storymgr_dashboard_slug', 'dashboard');
        if ($post->post_name !== $slug) return $content;

        return Shortcodes::dashboard([]);
    }
}
