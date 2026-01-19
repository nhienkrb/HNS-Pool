<?php
namespace StoryMgr\Admin\ListTable;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class CacheListTable extends \WP_List_Table {
    private string $tableName;

    public function __construct() {
        parent::__construct([
            'singular' => 'story_cache',
            'plural'   => 'story_cache',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->tableName = $wpdb->prefix . 'story_cache';
    }

    public function get_columns(): array {
        return [
            'story'          => __('Story', 'storymgr'),
            'total_chapters' => __('Total Chapters', 'storymgr'),
            'total_views'    => __('Total Views', 'storymgr'),
            'last_chapter'   => __('Last Chapter', 'storymgr'),
            'last_chapter_at'=> __('Last Chapter At', 'storymgr'),
            'updated_at'     => __('Updated At', 'storymgr'),
            'actions'        => __('Actions', 'storymgr'),
        ];
    }

    protected function get_sortable_columns(): array {
        return [
            'total_views'     => ['total_views', true],
            'total_chapters'  => ['total_chapters', false],
            'last_chapter_at' => ['last_chapter_at', false],
            'updated_at'      => ['updated_at', false],
        ];
    }

    public function column_story($item) {
        $sid = (int) $item['story_id'];
        $t = get_the_title($sid);
        $t = $t ? $t : ('#' . $sid);
        $link = get_edit_post_link($sid);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_total_chapters($item) { return (int) $item['total_chapters']; }
    public function column_total_views($item) { return (int) $item['total_views']; }

    public function column_last_chapter($item) {
        $no = $item['last_chapter_number'] ? (int) $item['last_chapter_number'] : null;
        return $no ? esc_html('#' . $no) : '—';
    }

    public function column_last_chapter_at($item) { return $item['last_chapter_at'] ? esc_html((string) $item['last_chapter_at']) : '—'; }
    public function column_updated_at($item) { return esc_html((string) $item['updated_at']); }

    public function column_actions($item) {
        $sid = (int) $item['story_id'];
        $url = add_query_arg(
            ['action' => 'storymgr_rebuild_story_cache', 'story_id' => $sid],
            admin_url('admin-post.php')
        );
        $url = wp_nonce_url($url, 'storymgr_rebuild_cache_' . $sid);
        return '<a class="button button-small" href="' . esc_url($url) . '">' . esc_html__('Rebuild', 'storymgr') . '</a>';
    }

    public function prepare_items(): void {
        global $wpdb;

        $perPage = 20;
        $paged   = $this->get_pagenum();
        $offset  = ($paged - 1) * $perPage;

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'total_views';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'DESC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'DESC';

        $allowed = ['total_views','total_chapters','last_chapter_at','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'total_views';

        $countSql = "SELECT COUNT(*) FROM {$this->tableName}";
        $totalItems = (int) $wpdb->get_var($countSql);

        $itemsSql = "SELECT story_id, total_chapters, total_views, last_chapter_id, last_chapter_number, last_chapter_at, updated_at
                      FROM {$this->tableName}
                      ORDER BY {$orderby} {$order}
                      LIMIT %d OFFSET %d";
        $itemsArgs = [$perPage, $offset];

        $this->items = $wpdb->get_results($wpdb->prepare($itemsSql, $itemsArgs), ARRAY_A);

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page'    => $perPage,
            'total_pages' => (int) ceil($totalItems / $perPage),
        ]);

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
    }
}
