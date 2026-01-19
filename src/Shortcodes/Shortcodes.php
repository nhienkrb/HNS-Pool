<?php
namespace StoryMgr\Shortcodes;

use StoryMgr\Features\Favorites;
use StoryMgr\Features\Progress;
use StoryMgr\Frontend\Frontend;

final class Shortcodes {
    public static function login($atts): string {
        if (is_user_logged_in()) {
            return '<p>' . esc_html__('You are already logged in.', 'storymgr') . '</p>';
        }

        $atts = shortcode_atts([
            'redirect' => '',
        ], $atts, 'storymgr_login');

        $redirect = $atts['redirect'] !== '' ? esc_url_raw($atts['redirect']) : (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return wp_login_form([
            'echo'     => false,
            'redirect' => $redirect,
        ]);
    }

    public static function register($atts): string {
        if (is_user_logged_in()) {
            return '<p>' . esc_html__('You are already logged in.', 'storymgr') . '</p>';
        }

        $atts = shortcode_atts([
            'redirect' => '',
        ], $atts, 'storymgr_register');

        $redirect = $atts['redirect'] !== '' ? esc_url_raw($atts['redirect']) : (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $error = isset($_GET['storymgr_register_error']) ? sanitize_text_field(wp_unslash($_GET['storymgr_register_error'])) : '';
        $errorMsg = '';

        switch ($error) {
            case 'missing_fields':
                $errorMsg = __('Please fill in all fields.', 'storymgr');
                break;
            case 'invalid_email':
                $errorMsg = __('Invalid email.', 'storymgr');
                break;
            case 'username_exists':
                $errorMsg = __('Username already exists.', 'storymgr');
                break;
            case 'email_exists':
                $errorMsg = __('Email already exists.', 'storymgr');
                break;
            case 'create_failed':
                $errorMsg = __('Account creation failed.', 'storymgr');
                break;
        }

        ob_start();
        if ($errorMsg !== '') {
            echo '<div class="storymgr-alert storymgr-alert-error">' . esc_html($errorMsg) . '</div>';
        }
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="storymgr_register" />
            <input type="hidden" name="_redirect" value="<?php echo esc_attr($redirect); ?>" />
            <?php wp_nonce_field('storymgr_register', 'storymgr_nonce'); ?>

            <p>
                <label for="storymgr_user_login"><?php esc_html_e('Username', 'storymgr'); ?></label><br />
                <input type="text" name="user_login" id="storymgr_user_login" required />
            </p>
            <p>
                <label for="storymgr_user_email"><?php esc_html_e('Email', 'storymgr'); ?></label><br />
                <input type="email" name="user_email" id="storymgr_user_email" required />
            </p>
            <p>
                <label for="storymgr_user_pass"><?php esc_html_e('Password', 'storymgr'); ?></label><br />
                <input type="password" name="user_pass" id="storymgr_user_pass" required />
            </p>
            <p>
                <button type="submit"><?php esc_html_e('Register', 'storymgr'); ?></button>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }

    public static function favoriteButton($atts): string {
        $atts = shortcode_atts([
            'story_id' => 0,
            'redirect' => '',
        ], $atts, 'storymgr_favorite_button');

        $storyId = (int) $atts['story_id'];
        if ($storyId <= 0 && is_singular('post')) {
            $storyId = get_the_ID();
        }
        if ($storyId <= 0) return '';

        if (!is_user_logged_in()) {
            $loginUrl = wp_login_url(get_permalink($storyId));
            return '<a class="storymgr-favorite-login" href="' . esc_url($loginUrl) . '">' . esc_html__('Login to favorite', 'storymgr') . '</a>';
        }

        $isFav = Favorites::isFavorite(get_current_user_id(), $storyId);
        $action = $isFav ? 'remove' : 'add';
        $label  = $isFav ? __('Remove from favorites', 'storymgr') : __('Add to favorites', 'storymgr');

        $redirect = $atts['redirect'] !== '' ? esc_url_raw($atts['redirect']) : get_permalink($storyId);

        ob_start();
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="storymgr-favorite-form">
            <input type="hidden" name="action" value="storymgr_toggle_favorite" />
            <input type="hidden" name="story_id" value="<?php echo esc_attr($storyId); ?>" />
            <input type="hidden" name="favorite_action" value="<?php echo esc_attr($action); ?>" />
            <input type="hidden" name="_redirect" value="<?php echo esc_attr($redirect); ?>" />
            <?php wp_nonce_field('storymgr_favorite_' . $storyId); ?>
            <button type="submit"><?php echo esc_html($label); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }

    public static function account($atts): string {
        if (!is_user_logged_in()) {
            $redirect = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $loginUrl = apply_filters('storymgr_login_url', home_url('/dang-nhap/'));
            $loginUrl = add_query_arg(['redirect' => rawurlencode($redirect)], $loginUrl);
            return '<p><a href="' . esc_url($loginUrl) . '">' . esc_html__('Login to view your account.', 'storymgr') . '</a></p>';
        }

        $userId = get_current_user_id();
        $favorites = Favorites::getUserFavoriteStoryIds($userId, 200, 0);
        $progressMap = Progress::getUserProgressMap($userId);

        ob_start();
        echo '<div class="storymgr-account">';
        echo '<h3>' . esc_html__('Favorites', 'storymgr') . '</h3>';

        if (empty($favorites)) {
            echo '<p>' . esc_html__('No favorites yet.', 'storymgr') . '</p>';
        } else {
            echo '<ul class="storymgr-favorite-list">';
            foreach ($favorites as $storyId) {
                $storyId = (int) $storyId;
                $title = get_the_title($storyId);
                $link = get_permalink($storyId);
                $title = $title ? $title : ('#' . $storyId);

                $continueLink = '';
                if (isset($progressMap[$storyId]) && !empty($progressMap[$storyId]['chapter_number'])) {
                    $chapterNumber = (int) $progressMap[$storyId]['chapter_number'];
                    $continueLink = Frontend::getChapterPermalink($storyId, $chapterNumber);
                }

                echo '<li>';
                echo '<a href="' . esc_url($link) . '">' . esc_html($title) . '</a>';
                if ($continueLink) {
                    echo ' - <a href="' . esc_url($continueLink) . '">' . esc_html__('Continue reading', 'storymgr') . '</a>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '<h3>' . esc_html__('Reading Progress', 'storymgr') . '</h3>';
        if (empty($progressMap)) {
            echo '<p>' . esc_html__('No reading progress yet.', 'storymgr') . '</p>';
        } else {
            echo '<ul class="storymgr-progress-list">';
            foreach ($progressMap as $storyId => $row) {
                $storyId = (int) $storyId;
                $title = get_the_title($storyId);
                $title = $title ? $title : ('#' . $storyId);
                $link = get_permalink($storyId);

                $chapterNumber = !empty($row['chapter_number']) ? (int) $row['chapter_number'] : 0;
                $continueLink = ($chapterNumber > 0)
                    ? Frontend::getChapterPermalink($storyId, $chapterNumber)
                    : '';

                echo '<li>';
                echo '<a href="' . esc_url($link) . '">' . esc_html($title) . '</a>';
                if ($continueLink) {
                    echo ' - <a href="' . esc_url($continueLink) . '">' . esc_html(sprintf(__('Chapter %d', 'storymgr'), $chapterNumber)) . '</a>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '</div>';

        return ob_get_clean();
    }

    public static function dashboard($atts): string {
        $atts = shortcode_atts([
            'limit' => 10,
        ], $atts, 'storymgr_dashboard');

        $limit = max(1, (int) $atts['limit']);

        $userId = get_current_user_id();
        $favoriteStoryIds = $userId ? Favorites::getUserFavoriteStoryIds($userId, 200, 0) : [];

        $favoriteAuthors = [];
        if (!empty($favoriteStoryIds)) {
            foreach ($favoriteStoryIds as $storyId) {
                $terms = get_the_terms((int) $storyId, 'story_author');
                if (is_array($terms)) {
                    foreach ($terms as $term) {
                        $favoriteAuthors[$term->term_id] = $term;
                    }
                }
            }
        }

        global $wpdb;
        $chaptersTable = $wpdb->prefix . 'story_chapters';
        $latestChapters = $wpdb->get_results($wpdb->prepare(
            "SELECT id, story_id, chapter_number, title, updated_at
             FROM {$chaptersTable}
             WHERE status = 1
             ORDER BY updated_at DESC
             LIMIT %d",
            $limit
        ), ARRAY_A);

        $latestStories = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'orderby'        => 'modified',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ]);

        $loginUrl = apply_filters('storymgr_login_url', home_url('/dang-nhap/'));
        $loginUrl = add_query_arg(['redirect' => rawurlencode(home_url('/'))], $loginUrl);

        ob_start();
        echo '<div class="storymgr-dashboard">';

        echo '<section class="storymgr-section storymgr-section-authors">';
        echo '<h3>' . esc_html__('Favorite Authors', 'storymgr') . '</h3>';
        if (!$userId) {
            echo '<p><a href="' . esc_url($loginUrl) . '">' . esc_html__('Login to view favorite authors.', 'storymgr') . '</a></p>';
        } elseif (empty($favoriteAuthors)) {
            echo '<p>' . esc_html__('No favorite authors yet.', 'storymgr') . '</p>';
        } else {
            echo '<ul>';
            foreach ($favoriteAuthors as $term) {
                $link = get_term_link($term, 'story_author');
                $name = $term->name ? $term->name : ('#' . $term->term_id);
                echo '<li><a href="' . esc_url($link) . '">' . esc_html($name) . '</a></li>';
            }
            echo '</ul>';
        }
        echo '</section>';

        echo '<section class="storymgr-section storymgr-section-favorites">';
        echo '<h3>' . esc_html__('Favorite Stories', 'storymgr') . '</h3>';
        if (!$userId) {
            echo '<p><a href="' . esc_url($loginUrl) . '">' . esc_html__('Login to view favorite stories.', 'storymgr') . '</a></p>';
        } elseif (empty($favoriteStoryIds)) {
            echo '<p>' . esc_html__('No favorites yet.', 'storymgr') . '</p>';
        } else {
            echo '<ul>';
            foreach ($favoriteStoryIds as $storyId) {
                $title = get_the_title((int) $storyId);
                $title = $title ? $title : ('#' . (int) $storyId);
                $link = get_permalink((int) $storyId);
                echo '<li><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></li>';
            }
            echo '</ul>';
        }
        echo '</section>';

        echo '<section class="storymgr-section storymgr-section-latest-chapters">';
        echo '<h3>' . esc_html__('Latest Updated Chapters', 'storymgr') . '</h3>';
        if (empty($latestChapters)) {
            echo '<p>' . esc_html__('No chapters found.', 'storymgr') . '</p>';
        } else {
            echo '<ul>';
            foreach ($latestChapters as $row) {
                $storyId = (int) $row['story_id'];
                $storyTitle = get_the_title($storyId);
                $storyTitle = $storyTitle ? $storyTitle : ('#' . $storyId);
                $chapterNo = (int) $row['chapter_number'];
                $chapterTitle = (string) $row['title'];
                $link = Frontend::getChapterPermalink($storyId, $chapterNo);
                $label = sprintf('%s — Ch.%d: %s', $storyTitle, $chapterNo, $chapterTitle);
                echo '<li>';
                if ($link) {
                    echo '<a href="' . esc_url($link) . '">' . esc_html($label) . '</a>';
                } else {
                    echo esc_html($label);
                }
                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</section>';

        echo '<section class="storymgr-section storymgr-section-latest-stories">';
        echo '<h3>' . esc_html__('Latest Updated Stories', 'storymgr') . '</h3>';
        if (empty($latestStories)) {
            echo '<p>' . esc_html__('No stories found.', 'storymgr') . '</p>';
        } else {
            echo '<ul>';
            foreach ($latestStories as $story) {
                $title = $story->post_title ? $story->post_title : ('#' . $story->ID);
                $link = get_permalink($story->ID);
                echo '<li><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></li>';
            }
            echo '</ul>';
        }
        echo '</section>';

        echo '</div>';

        return ob_get_clean();
    }
}
