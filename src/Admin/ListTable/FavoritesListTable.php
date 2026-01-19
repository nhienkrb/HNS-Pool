<?php
namespace StoryMgr\Admin\ListTable;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class FavoritesListTable extends \WP_List_Table {
    private string $tableName;

    public function __construct() {
        parent::__construct([
            'singular' => 'favorite',
            'plural'   => 'favorites',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->tableName = $wpdb->prefix . 'story_favorites';
    }

    public function get_columns(): array {
        return [
            'id'               => 'ID',
            'user'             => __('User', 'storymgr'),
            'story'            => __('Story', 'storymgr'),
            'story_favorites'  => __('Story Favorites', 'storymgr'),
            'created_at'       => __('Created', 'storymgr'),
            'actions'          => __('Actions', 'storymgr'),
        ];
    }

    protected function get_sortable_columns(): array {
        return [
            'created_at' => ['created_at', true],
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

    public function column_story_favorites($item) {
        return (int) $item['story_favorites'];
    }

    public function column_created_at($item) {
        return esc_html((string) $item['created_at']);
    }

    public function column_actions($item) {
        $id = (int) $item['id'];
        $url = add_query_arg(
            ['action' => 'storymgr_delete_favorite', 'id' => $id],
            admin_url('admin-post.php')
        );
        $url = wp_nonce_url($url, 'storymgr_delete_favorite_' . $id);
        return '<a class="button button-small" href="' . esc_url($url) . '" onclick="return confirm(\'Delete this favorite?\');">' . esc_html__('Delete', 'storymgr') . '</a>';
    }

    public function prepare_items(): void {
        global $wpdb;

        $perPage = 20;
        $paged   = $this->get_pagenum();
        $offset  = ($paged - 1) * $perPage;

        $userId  = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;
        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'created_at';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'DESC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'DESC';

        $allowed = ['id','created_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'created_at';

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

        $itemsSql = "SELECT f.id, f.user_id, f.story_id, f.created_at,
                             (SELECT COUNT(*) FROM {$this->tableName} f2 WHERE f2.story_id = f.story_id) AS story_favorites
                      FROM {$this->tableName} f
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
