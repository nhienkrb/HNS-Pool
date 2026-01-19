<?php
namespace StoryMgr\Frontend;

use StoryMgr\Support\Seo;
use StoryMgr\Features\Views;

final class Frontend {
    public static function getChapterBaseSlug(): string {
        return (string) apply_filters('storymgr_chapter_base_slug', 'truyen');
    }

    public static function getChapterPrefix(): string {
        return (string) apply_filters('storymgr_chapter_prefix', 'chuong');
    }

    public static function getEffectiveChapterBase(): string {
        $base = trim(self::getChapterBaseSlug(), '/');
        $sitePath = trim((string) parse_url(home_url(), PHP_URL_PATH), '/');

        if ($base !== '' && $sitePath !== '' && $base === $sitePath) {
            return '';
        }

        return $base;
    }

    public static function registerChapterPostType(): void {
        register_post_type('story_chapter', [
            'label'              => __('Story Chapter', 'storymgr'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => false,
            'show_in_rest'       => false,
            'rewrite'            => false,
            'supports'           => ['title', 'editor'],
        ]);
    }

    public static function registerChapterRewrites(): void {
        $base   = self::getEffectiveChapterBase();
        $prefix = trim(self::getChapterPrefix(), '/');

        if ($prefix === '') {
            return;
        }

        $pattern = $base === ''
            ? '^([^/]+)/' . preg_quote($prefix, '/') . '-([0-9]+)/?$'
            : '^' . preg_quote($base, '/') . '/([^/]+)/' . preg_quote($prefix, '/') . '-([0-9]+)/?$';

        add_rewrite_rule(
            $pattern,
            'index.php?storymgr_story=$matches[1]&storymgr_chapter=$matches[2]',
            'top'
        );
    }

    public static function addQueryVars(array $vars): array {
        $vars[] = 'storymgr_story';
        $vars[] = 'storymgr_chapter';
        return $vars;
    }

    public static function isChapterQuery($query = null): bool {
        if ($query instanceof \WP_Query) {
            $story = $query->get('storymgr_story');
            $chap  = $query->get('storymgr_chapter');
        } else {
            $story = get_query_var('storymgr_story');
            $chap  = get_query_var('storymgr_chapter');
        }

        return ($story !== '' && $story !== null && $chap !== '' && $chap !== null);
    }

    public static function getCurrentChapterData() {
        static $data = null;

        if ($data !== null) {
            return $data;
        }

        $storySlug = get_query_var('storymgr_story');
        $chapterNo = absint(get_query_var('storymgr_chapter'));

        if (!$storySlug || $chapterNo <= 0) {
            $data = false;
            return $data;
        }

        $story = get_page_by_path($storySlug, OBJECT, 'post');
        if (!$story) {
            $data = false;
            return $data;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'story_chapters';

        $chapter = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE story_id = %d AND chapter_number = %d AND status = 1",
            $story->ID,
            $chapterNo
        ), ARRAY_A);

        if (!$chapter) {
            $data = false;
            return $data;
        }

        $data = [
            'story'   => $story,
            'chapter' => $chapter,
        ];

        return $data;
    }

    public static function injectVirtualChapter(array $posts, \WP_Query $query): array {
        if (!self::isChapterQuery($query) || !$query->is_main_query()) {
            return $posts;
        }

        $data = self::getCurrentChapterData();
        if (!$data) {
            $query->set_404();
            return [];
        }

        $chapter = $data['chapter'];
        $story   = $data['story'];

        $chapterNumber = (int) $chapter['chapter_number'];
        $chapterSlug   = $chapter['slug'] ? (string) $chapter['slug'] : sanitize_title('chuong-' . $chapterNumber);
        $publishedAt   = !empty($chapter['published_at']) ? (string) $chapter['published_at'] : (string) $chapter['created_at'];
        $authorId      = !empty($chapter['created_by']) ? (int) $chapter['created_by'] : (int) $story->post_author;

        $virtual = new \WP_Post((object)[
            'ID'                => -1 * (int) $chapter['id'],
            'post_author'       => $authorId,
            'post_date'         => $publishedAt,
            'post_date_gmt'     => get_gmt_from_date($publishedAt),
            'post_content'      => (string) $chapter['content'],
            'post_title'        => (string) $chapter['title'],
            'post_excerpt'      => '',
            'post_status'       => 'publish',
            'comment_status'    => 'closed',
            'ping_status'       => 'closed',
            'post_name'         => $chapterSlug,
            'post_type'         => 'story_chapter',
            'filter'            => 'raw',
        ]);

        $query->is_home              = false;
        $query->is_page              = false;
        $query->is_single            = true;
        $query->is_singular          = true;
        $query->is_archive           = false;
        $query->is_post_type_archive = false;
        $query->is_404               = false;
        $query->found_posts          = 1;
        $query->max_num_pages        = 1;
        $query->queried_object       = $virtual;
        $query->queried_object_id    = $virtual->ID;

        Views::handleChapterView($chapter, $story);

        return [$virtual];
    }

    public static function chapterDocumentTitle(array $parts): array {
        if (!self::isChapterQuery()) {
            return $parts;
        }

        $data = self::getCurrentChapterData();
        if (!$data) {
            return $parts;
        }

        $chapter = $data['chapter'];
        $story   = $data['story'];
        $fallback = Seo::makeTitle($story->post_title, (int) $chapter['chapter_number'], (string) $chapter['title']);

        $parts['title'] = $chapter['seo_title'] ? (string) $chapter['seo_title'] : $fallback;
        return $parts;
    }

    public static function chapterMetaDescription(): void {
        if (!self::isChapterQuery()) {
            return;
        }

        if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
            return;
        }

        $data = self::getCurrentChapterData();
        if (!$data) {
            return;
        }

        $chapter = $data['chapter'];
        $desc = $chapter['seo_description']
            ? (string) $chapter['seo_description']
            : Seo::makeDescriptionFromContent((string) $chapter['content'], 160);

        if ($desc === '') {
            return;
        }

        echo '<meta name="description" content="' . esc_attr($desc) . "\" />\n";
    }

    public static function chapterWpseoTitle(string $title): string {
        if (!self::isChapterQuery()) {
            return $title;
        }

        $data = self::getCurrentChapterData();
        if (!$data) {
            return $title;
        }

        $chapter = $data['chapter'];
        $story   = $data['story'];
        $fallback = Seo::makeTitle($story->post_title, (int) $chapter['chapter_number'], (string) $chapter['title']);

        return $chapter['seo_title'] ? (string) $chapter['seo_title'] : $fallback;
    }

    public static function chapterWpseoMetadesc(string $desc): string {
        if (!self::isChapterQuery()) {
            return $desc;
        }

        $data = self::getCurrentChapterData();
        if (!$data) {
            return $desc;
        }

        $chapter = $data['chapter'];
        $fallback = Seo::makeDescriptionFromContent((string) $chapter['content'], 160);
        return $chapter['seo_description'] ? (string) $chapter['seo_description'] : $fallback;
    }

    public static function chapterRankMathTitle(string $title): string {
        return self::chapterWpseoTitle($title);
    }

    public static function chapterRankMathDescription(string $desc): string {
        return self::chapterWpseoMetadesc($desc);
    }

    public static function preGetShortlink($shortlink, $id, $context, $allowSlugs) {
        if (self::isChapterQuery()) {
            return '';
        }

        return $shortlink;
    }

    public static function getChapterPermalink(int $storyId, int $chapterNumber): string {
        $story = get_post($storyId);
        if (!$story) {
            return '';
        }

        $base   = self::getEffectiveChapterBase();
        $prefix = trim(self::getChapterPrefix(), '/');

        if ($prefix === '') {
            return '';
        }

        if ($base === '') {
            return home_url(sprintf('%s/%s-%d/', $story->post_name, $prefix, $chapterNumber));
        }

        return home_url(sprintf('%s/%s/%s-%d/', $base, $story->post_name, $prefix, $chapterNumber));
    }
}
