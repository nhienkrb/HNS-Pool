<?php
namespace StoryMgr\Features;

final class Favorites {
    public static function tableFavorites(): string {
        global $wpdb;
        return $wpdb->prefix . 'story_favorites';
    }

    public static function addFavorite(int $userId, int $storyId) {
        global $wpdb;

        if ($userId <= 0 || $storyId <= 0) return false;

        $table = self::tableFavorites();
        $now   = current_time('mysql');

        $sql = $wpdb->prepare(
            "INSERT IGNORE INTO {$table} (user_id, story_id, created_at)
             VALUES (%d, %d, %s)",
            $userId, $storyId, $now
        );

        return $wpdb->query($sql);
    }

    public static function removeFavorite(int $userId, int $storyId) {
        global $wpdb;

        if ($userId <= 0 || $storyId <= 0) return false;

        $table = self::tableFavorites();
        return $wpdb->delete($table, ['user_id' => $userId, 'story_id' => $storyId], ['%d', '%d']);
    }

    public static function isFavorite(int $userId, int $storyId): bool {
        global $wpdb;

        if ($userId <= 0 || $storyId <= 0) return false;

        $table = self::tableFavorites();
        $found = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT 1 FROM {$table} WHERE user_id = %d AND story_id = %d LIMIT 1",
            $userId, $storyId
        ));

        return $found === 1;
    }

    public static function getUserFavoriteStoryIds(int $userId, int $limit = 100, int $offset = 0): array {
        global $wpdb;

        $limit  = max(1, $limit);
        $offset = max(0, $offset);
        if ($userId <= 0) return [];

        $table = self::tableFavorites();
        return $wpdb->get_col($wpdb->prepare(
            "SELECT story_id FROM {$table}
             WHERE user_id = %d
             ORDER BY created_at DESC
             LIMIT %d OFFSET %d",
            $userId, $limit, $offset
        ));
    }

    public static function handleToggleFavorite(): void {
        $storyId = isset($_POST['story_id']) ? absint($_POST['story_id']) : 0;
        $action  = isset($_POST['favorite_action']) ? sanitize_text_field(wp_unslash($_POST['favorite_action'])) : '';
        $nonce   = isset($_POST['_wpnonce']) ? sanitize_text_field(wp_unslash($_POST['_wpnonce'])) : '';

        if ($storyId <= 0 || !wp_verify_nonce($nonce, 'storymgr_favorite_' . $storyId)) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        if (!is_user_logged_in()) {
            $redirect = isset($_POST['_redirect']) ? esc_url_raw(wp_unslash($_POST['_redirect'])) : '';
            $loginUrl = wp_login_url($redirect ? $redirect : home_url('/'));
            wp_safe_redirect($loginUrl);
            exit;
        }

        $userId = get_current_user_id();
        if ($action === 'remove') {
            self::removeFavorite($userId, $storyId);
        } else {
            self::addFavorite($userId, $storyId);
        }

        $redirect = isset($_POST['_redirect']) ? esc_url_raw(wp_unslash($_POST['_redirect'])) : '';
        if ($redirect === '') {
            $redirect = get_permalink($storyId);
        }

        wp_safe_redirect($redirect);
        exit;
    }

    public static function handleDeleteFavorite(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('No permission', 'storymgr'));
        }

        $id    = isset($_GET['id']) ? absint($_GET['id']) : 0;
        $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

        if ($id <= 0 || !wp_verify_nonce($nonce, 'storymgr_delete_favorite_' . $id)) {
            wp_die(esc_html__('Invalid request', 'storymgr'));
        }

        global $wpdb;
        $table = self::tableFavorites();
        $wpdb->delete($table, ['id' => $id], ['%d']);

        wp_safe_redirect(admin_url('admin.php?page=storymgr-favorites&deleted=1'));
        exit;
    }
}
