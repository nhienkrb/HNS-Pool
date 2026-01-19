<?php
namespace StoryMgr\Admin\ListTable;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class ProgressListTable extends \WP_List_Table {
    private string $tableName;

    public function __construct() {
        parent::__construct([
            'singular' => 'progress',
            'plural'   => 'progress',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->tableName = $wpdb->prefix . 'user_story_progress';
    }

    public function get_columns(): array {
        return [
            'id'               => 'ID',
            'user'             => __('User', 'storymgr'),
            'story'            => __('Story', 'storymgr'),
            'chapter_id'       => __('Chapter ID', 'storymgr'),
            'progress_percent' => __('Progress %', 'storymgr'),
            'updated_at'       => __('Updated', 'storymgr'),
            'actions'          => __('Actions', 'storymgr'),
        ];
    }

    protected function get_sortable_columns(): array {
        return [
            'updated_at' => ['updated_at', true],
            'id'         => ['id', false],
        ];
    }

    public function column_id($item) { return (int) $item['id']; }

    public function column_user($item) {
        $u = get_user_by('id', (int) $item['user_id']);
        if (!$u) return esc_html('#' . (int) $item['user_id']);
        $link = get_edit_user_link($u->ID);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($u->display_name) . '</a>' : esc_html($u->display_name);
    }

    public function column_story($item) {
        $sid = (int) $item['story_id'];
        $t = get_the_title($sid);
        $t = $t ? $t : ('#' . $sid);
        $link = get_edit_post_link($sid);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_chapter_id($item) {
        return $item['chapter_id'] ? esc_html((string) $item['chapter_id']) : '—';
    }

    public function column_progress_percent($item) {
        return isset($item['progress_percent'])
            ? esc_html(number_format((float) $item['progress_percent'], 2))
            : '0.00';
    }

    public function column_updated_at($item) {
        return esc_html((string) $item['updated_at']);
    }

    public function column_actions($item) {
        $id = (int) $item['id'];
        $url = add_query_arg(
            ['action' => 'storymgr_delete_progress', 'id' => $id],
            admin_url('admin-post.php')
        );
        $url = wp_nonce_url($url, 'storymgr_delete_progress_' . $id);
        return '<a class="button button-small" href="' . esc_url($url) . '" onclick="return confirm(\'Delete this progress row?\');">' . esc_html__('Delete', 'storymgr') . '</a>';
    }

    public function prepare_items(): void {
        global $wpdb;

        $perPage = 20;
        $paged   = $this->get_pagenum();
        $offset  = ($paged - 1) * $perPage;

        $userId  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'updated_at';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'DESC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'DESC';

        $allowed = ['id','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'updated_at';

        $where = 'WHERE 1=1';
        $args = [];

        if ($userId > 0) {
            $where .= ' AND user_id = %d';
            $args[] = $userId;
        }
        if ($storyId > 0) {
            $where .= ' AND story_id = %d';
            $args[] = $storyId;
        }

        $countSql = "SELECT COUNT(*) FROM {$this->tableName} {$where}";
        if ($args) {
            $totalItems = (int) $wpdb->get_var($wpdb->prepare($countSql, $args));
        } else {
            $totalItems = (int) $wpdb->get_var($countSql);
        }

        $itemsSql = "SELECT id, user_id, story_id, chapter_id, progress_percent, updated_at
                      FROM {$this->tableName}
                      {$where}
                      ORDER BY {$orderby} {$order}
                      LIMIT %d OFFSET %d";
        $itemsArgs = array_merge($args, [$perPage, $offset]);

        $this->items = $wpdb->get_results($wpdb->prepare($itemsSql, $itemsArgs), ARRAY_A);

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page'    => $perPage,
            'total_pages' => (int) ceil($totalItems / $perPage),
        ]);

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
    }
}
