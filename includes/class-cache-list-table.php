<?php
defined('ABSPATH') || exit;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class StoryMGR_Cache_List_Table extends WP_List_Table {

    private $table_name;

    public function __construct() {
        parent::__construct([
            'singular' => 'story_cache',
            'plural'   => 'story_cache',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'story_cache';
    }

    public function get_columns() {
        return [
            'story_id'       => __('Story ID', 'storymgr'),
            'story'          => __('Story', 'storymgr'),
            'total_chapters' => __('Total Chapters', 'storymgr'),
            'total_views'    => __('Total Views', 'storymgr'),
            'last_chapter_at'=> __('Last Chapter At', 'storymgr'),
            'updated_at'     => __('Updated', 'storymgr'),
            'actions'        => __('Actions', 'storymgr'),
        ];
    }

    protected function get_sortable_columns() {
        return [
            'total_views'     => ['total_views', true],
            'total_chapters'  => ['total_chapters', false],
            'last_chapter_at' => ['last_chapter_at', false],
            'updated_at'      => ['updated_at', false],
        ];
    }

    public function column_story_id($item) { return (int)$item['story_id']; }

    public function column_story($item) {
        $sid = (int)$item['story_id'];
        $t = get_the_title($sid);
        $t = $t ? $t : ('#' . $sid);
        $link = get_edit_post_link($sid);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_total_chapters($item) { return (int)$item['total_chapters']; }
    public function column_total_views($item) { return (int)$item['total_views']; }
    public function column_last_chapter_at($item) { return $item['last_chapter_at'] ? esc_html((string)$item['last_chapter_at']) : '—'; }
    public function column_updated_at($item) { return esc_html((string)$item['updated_at']); }

    public function column_actions($item) {
        $sid = (int)$item['story_id'];
        $url = add_query_arg(
            ['action' => 'storymgr_rebuild_story_cache', 'story_id' => $sid],
            admin_url('admin-post.php')
        );
        $url = wp_nonce_url($url, 'storymgr_rebuild_cache_' . $sid);
        return '<a class="button button-small" href="' . esc_url($url) . '">' . esc_html__('Rebuild', 'storymgr') . '</a>';
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 20;
        $paged    = $this->get_pagenum();
        $offset   = ($paged - 1) * $per_page;

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'updated_at';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'DESC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'DESC';

        $allowed = ['total_views','total_chapters','last_chapter_at','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'updated_at';

        $count_sql = "SELECT COUNT(*) FROM {$this->table_name}";
        $total_items = (int)$wpdb->get_var($count_sql);

        $items_sql = "SELECT story_id, total_chapters, total_views, last_chapter_at, updated_at
                      FROM {$this->table_name}
                      ORDER BY {$orderby} {$order}
                      LIMIT %d OFFSET %d";

        $this->items = $wpdb->get_results(
            $wpdb->prepare($items_sql, $per_page, $offset),
            ARRAY_A
        );

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => (int)ceil($total_items / $per_page),
        ]);

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
    }
}
