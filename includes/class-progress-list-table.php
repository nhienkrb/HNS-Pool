<?php
defined('ABSPATH') || exit;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class StoryMGR_Progress_List_Table extends WP_List_Table {

    private $table_name;

    public function __construct() {
        parent::__construct([
            'singular' => 'progress',
            'plural'   => 'progress',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'user_story_progress';
    }

    public function get_columns() {
        return [
            'id'        => 'ID',
            'user'      => __('User', 'storymgr'),
            'story'     => __('Story', 'storymgr'),
            'chapter_id'=> __('Chapter ID', 'storymgr'),
            'updated_at'=> __('Updated', 'storymgr'),
            'actions'   => __('Actions', 'storymgr'),
        ];
    }

    protected function get_sortable_columns() {
        return [
            'updated_at' => ['updated_at', true],
            'id'         => ['id', false],
        ];
    }

    public function column_id($item) { return (int)$item['id']; }

    public function column_user($item) {
        $u = get_user_by('id', (int)$item['user_id']);
        if (!$u) return esc_html('#' . (int)$item['user_id']);
        $link = get_edit_user_link($u->ID);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($u->display_name) . '</a>' : esc_html($u->display_name);
    }

    public function column_story($item) {
        $sid = (int)$item['story_id'];
        $t = get_the_title($sid);
        $t = $t ? $t : ('#' . $sid);
        $link = get_edit_post_link($sid);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_chapter_id($item) {
        return $item['chapter_id'] ? esc_html((string)$item['chapter_id']) : '—';
    }

    public function column_updated_at($item) {
        return esc_html((string)$item['updated_at']);
    }

    public function column_actions($item) {
        $id = (int)$item['id'];
        $url = add_query_arg(
            ['action' => 'storymgr_delete_progress', 'id' => $id],
            admin_url('admin-post.php')
        );
        $url = wp_nonce_url($url, 'storymgr_delete_progress_' . $id);
        return '<a class="button button-small" href="' . esc_url($url) . '" onclick="return confirm(\'Delete this progress row?\');">' . esc_html__('Delete', 'storymgr') . '</a>';
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 20;
        $paged    = $this->get_pagenum();
        $offset   = ($paged - 1) * $per_page;

        $user_id  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
        $story_id = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'updated_at';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'DESC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'DESC';

        $allowed = ['id','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'updated_at';

        $where = 'WHERE 1=1';
        $args = [];

        if ($user_id > 0) {
            $where .= ' AND user_id = %d';
            $args[] = $user_id;
        }
        if ($story_id > 0) {
            $where .= ' AND story_id = %d';
            $args[] = $story_id;
        }

        $count_sql = "SELECT COUNT(*) FROM {$this->table_name} {$where}";
        $total_items = (int)$wpdb->get_var($wpdb->prepare($count_sql, $args));

        $items_sql = "SELECT id, user_id, story_id, chapter_id, updated_at
                      FROM {$this->table_name}
                      {$where}
                      ORDER BY {$orderby} {$order}
                      LIMIT %d OFFSET %d";
        $items_args = array_merge($args, [$per_page, $offset]);

        $this->items = $wpdb->get_results($wpdb->prepare($items_sql, $items_args), ARRAY_A);

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => (int)ceil($total_items / $per_page),
        ]);

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
    }
}
