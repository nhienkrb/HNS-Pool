<?php
defined('ABSPATH') || exit;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class StoryMGR_Chapter_List_Table extends WP_List_Table {

    private $table_name;

    public function __construct() {
        parent::__construct([
            'singular' => 'chapter',
            'plural'   => 'chapters',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'story_chapters';
    }

    public function get_columns() {
        return [
            'cb'            => '<input type="checkbox" />',
            'id'            => 'ID',
            'story'         => __('Story', 'storymgr'),
            'chapter_number'=> __('#', 'storymgr'),
            'title'         => __('Title', 'storymgr'),
            'status'        => __('Status', 'storymgr'),
            'created_at'    => __('Created', 'storymgr'),
            'updated_at'    => __('Updated', 'storymgr'),
        ];
    }

    protected function get_sortable_columns() {
        return [
            'id'             => ['id', false],
            'chapter_number' => ['chapter_number', true],
            'title'          => ['title', false],
            'created_at'     => ['created_at', false],
            'updated_at'     => ['updated_at', false],
        ];
    }

    protected function column_cb($item) {
        return sprintf('<input type="checkbox" name="chapter_id[]" value="%d" />', (int)$item['id']);
    }

    public function column_id($item) { return (int)$item['id']; }

    public function column_story($item) {
        $story_id = (int)$item['story_id'];
        $t = get_the_title($story_id);
        $t = $t ? $t : ('#' . $story_id);
        $link = get_edit_post_link($story_id);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_chapter_number($item) { return (int)$item['chapter_number']; }

    public function column_status($item) {
        return ((int)$item['status'] === 1) ? esc_html__('Published', 'storymgr') : esc_html__('Draft', 'storymgr');
    }

    public function column_created_at($item) { return esc_html((string)$item['created_at']); }
    public function column_updated_at($item) { return esc_html((string)$item['updated_at']); }

    public function column_title($item) {
        $id = (int)$item['id'];

        $edit_url = add_query_arg(
            ['page' => 'storymgr-add-chapter', 'chapter_id' => $id],
            admin_url('admin.php')
        );

        $delete_url = add_query_arg(
            ['action' => 'storymgr_delete_chapter', 'chapter_id' => $id],
            admin_url('admin-post.php')
        );
        $delete_url = wp_nonce_url($delete_url, 'storymgr_delete_chapter_' . $id);

        $actions = [
            'edit'   => '<a href="' . esc_url($edit_url) . '">' . esc_html__('Edit', 'storymgr') . '</a>',
            'delete' => '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Delete this chapter?\');">' . esc_html__('Delete', 'storymgr') . '</a>',
        ];

        return esc_html((string)$item['title']) . $this->row_actions($actions);
    }

    protected function get_bulk_actions() {
        return ['bulk_delete' => __('Delete', 'storymgr')];
    }

    public function process_bulk_action() {
        if ($this->current_action() !== 'bulk_delete') return;

        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('No permission', 'storymgr'));
        }
        check_admin_referer('storymgr_bulk_chapters');

        $ids = isset($_REQUEST['chapter_id']) ? (array)$_REQUEST['chapter_id'] : [];
        $ids = array_filter(array_map('absint', $ids));
        if (!$ids) return;

        global $wpdb;
        $deleted = 0;
        $touched_stories = [];

        foreach ($ids as $id) {
            $sid = (int)$wpdb->get_var($wpdb->prepare("SELECT story_id FROM {$this->table_name} WHERE id=%d", $id));
            $ok  = $wpdb->delete($this->table_name, ['id' => $id], ['%d']);
            if ($ok !== false) {
                $deleted++;
                if ($sid > 0) $touched_stories[$sid] = true;
            }
        }

        // rebuild cache for  stories
        foreach (array_keys($touched_stories) as $sid) {
            storymgr_rebuild_story_cache((int)$sid);
        }

        $redirect = remove_query_arg(['action','action2','_wpnonce','chapter_id']);
        $redirect = add_query_arg(['deleted_count' => $deleted], $redirect);
        wp_safe_redirect($redirect);
        exit;
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 20;
        $paged    = $this->get_pagenum();
        $offset   = ($paged - 1) * $per_page;

        $story_id = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;
        $status   = isset($_REQUEST['status']) ? sanitize_text_field(wp_unslash($_REQUEST['status'])) : '';
        $search   = isset($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'chapter_number';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'ASC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'ASC';

        $allowed = ['id','chapter_number','title','created_at','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'chapter_number';

        $where = 'WHERE 1=1';
        $args  = [];

        if ($story_id > 0) {
            $where .= ' AND story_id = %d';
            $args[] = $story_id;
        }

        if ($status === 'published') $where .= ' AND status = 1';
        if ($status === 'draft')     $where .= ' AND status = 0';

        if ($search !== '') {
            $like = '%' . $wpdb->esc_like($search) . '%';
            $where .= ' AND (title LIKE %s)';
            $args[] = $like;
        }

        $count_sql = "SELECT COUNT(*) FROM {$this->table_name} {$where}";
        $total_items = (int)$wpdb->get_var($wpdb->prepare($count_sql, $args));

        $items_sql = "SELECT id, story_id, chapter_number, title, status, created_at, updated_at
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
