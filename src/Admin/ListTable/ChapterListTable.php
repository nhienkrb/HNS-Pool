<?php
namespace StoryMgr\Admin\ListTable;

use StoryMgr\Features\Cache;
use StoryMgr\Frontend\Frontend;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class ChapterListTable extends \WP_List_Table {
    private string $tableName;

    public function __construct() {
        parent::__construct([
            'singular' => 'chapter',
            'plural'   => 'chapters',
            'ajax'     => false,
        ]);

        global $wpdb;
        $this->tableName = $wpdb->prefix . 'story_chapters';
    }

    public function get_columns(): array {
        return [
            'cb'             => '<input type="checkbox" />',
            'id'             => 'ID',
            'story'          => __('Story', 'storymgr'),
            'chapter_number' => __('#', 'storymgr'),
            'title'          => __('Title', 'storymgr'),
            'views'          => __('Views', 'storymgr'),
            'status'         => __('Status', 'storymgr'),
            'created_at'     => __('Created', 'storymgr'),
            'updated_at'     => __('Updated', 'storymgr'),
        ];
    }

    protected function get_sortable_columns(): array {
        return [
            'id'             => ['id', false],
            'chapter_number' => ['chapter_number', true],
            'title'          => ['title', false],
            'views'          => ['views', false],
            'created_at'     => ['created_at', false],
            'updated_at'     => ['updated_at', false],
        ];
    }

    protected function column_cb($item): string {
        return sprintf('<input type="checkbox" name="chapter_id[]" value="%d" />', (int) $item['id']);
    }

    public function column_id($item) { return (int) $item['id']; }

    public function column_story($item) {
        $storyId = (int) $item['story_id'];
        $t = get_the_title($storyId);
        $t = $t ? $t : ('#' . $storyId);
        $link = get_edit_post_link($storyId);
        return $link ? '<a href="' . esc_url($link) . '">' . esc_html($t) . '</a>' : esc_html($t);
    }

    public function column_chapter_number($item) { return (int) $item['chapter_number']; }
    public function column_views($item) { return (int) $item['views']; }

    public function column_status($item) {
        return ((int) $item['status'] === 1) ? esc_html__('Published', 'storymgr') : esc_html__('Draft', 'storymgr');
    }

    public function column_created_at($item) { return esc_html((string) $item['created_at']); }
    public function column_updated_at($item) { return esc_html((string) $item['updated_at']); }

    public function column_title($item) {
        $id = (int) $item['id'];
        $storyId = (int) $item['story_id'];
        $chapterNo = (int) $item['chapter_number'];

        $viewUrl = add_query_arg(
            ['page' => 'storymgr-view-chapter', 'chapter_id' => $id],
            admin_url('admin.php')
        );
        $frontUrl = Frontend::getChapterPermalink($storyId, $chapterNo);

        $editUrl = add_query_arg(
            ['page' => 'storymgr-add-chapter', 'chapter_id' => $id],
            admin_url('admin.php')
        );

        $deleteUrl = add_query_arg(
            ['action' => 'storymgr_delete_chapter', 'chapter_id' => $id],
            admin_url('admin-post.php')
        );
        $deleteUrl = wp_nonce_url($deleteUrl, 'storymgr_delete_chapter_' . $id);

        $actions = [
            'view'   => '<a href="' . esc_url($viewUrl) . '">' . esc_html__('View', 'storymgr') . '</a>',
            'front'  => $frontUrl ? '<a href="' . esc_url($frontUrl) . '" target="_blank" rel="noopener">' . esc_html__('View Public', 'storymgr') . '</a>' : '',
            'edit'   => '<a href="' . esc_url($editUrl) . '">' . esc_html__('Edit', 'storymgr') . '</a>',
            'delete' => '<a href="' . esc_url($deleteUrl) . '" onclick="return confirm(\'Delete this chapter?\');">' . esc_html__('Delete', 'storymgr') . '</a>',
        ];

        $actions = array_filter($actions);
        return esc_html((string) $item['title']) . $this->row_actions($actions);
    }

    protected function get_bulk_actions(): array {
        return ['bulk_delete' => __('Delete', 'storymgr')];
    }

    public function process_bulk_action(): void {
        if ($this->current_action() !== 'bulk_delete') return;

        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('No permission', 'storymgr'));
        }
        check_admin_referer('storymgr_bulk_chapters');

        $ids = isset($_REQUEST['chapter_id']) ? (array) $_REQUEST['chapter_id'] : [];
        $ids = array_filter(array_map('absint', $ids));
        if (!$ids) return;

        global $wpdb;
        $deleted = 0;
        $touchedStories = [];

        foreach ($ids as $id) {
            $sid = (int) $wpdb->get_var($wpdb->prepare("SELECT story_id FROM {$this->tableName} WHERE id=%d", $id));
            $ok  = $wpdb->delete($this->tableName, ['id' => $id], ['%d']);
            if ($ok !== false) {
                $deleted++;
                if ($sid > 0) $touchedStories[$sid] = true;
            }
        }

        foreach (array_keys($touchedStories) as $sid) {
            Cache::rebuildStoryCache((int) $sid);
        }

        $redirect = remove_query_arg(['action','action2','_wpnonce','chapter_id']);
        $redirect = add_query_arg(['deleted_count' => $deleted], $redirect);
        wp_safe_redirect($redirect);
        exit;
    }

    public function prepare_items(): void {
        global $wpdb;

        $perPage = 20;
        $paged   = $this->get_pagenum();
        $offset  = ($paged - 1) * $perPage;

        $storyId = isset($_REQUEST['story_id']) ? absint($_REQUEST['story_id']) : 0;
        $status  = isset($_REQUEST['status']) ? sanitize_text_field(wp_unslash($_REQUEST['status'])) : '';
        $search  = isset($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';

        $orderby = isset($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'chapter_number';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field($_REQUEST['order'])) : 'ASC';
        $order   = in_array($order, ['ASC','DESC'], true) ? $order : 'ASC';

        $allowed = ['id','chapter_number','title','views','created_at','updated_at'];
        if (!in_array($orderby, $allowed, true)) $orderby = 'chapter_number';

        $where = 'WHERE 1=1';
        $args  = [];

        if ($storyId > 0) {
            $where .= ' AND story_id = %d';
            $args[] = $storyId;
        }

        if ($status === 'published') $where .= ' AND status = 1';
        if ($status === 'draft')     $where .= ' AND status = 0';

        if ($search !== '') {
            $like = '%' . $wpdb->esc_like($search) . '%';
            $where .= ' AND (title LIKE %s)';
            $args[] = $like;
        }

        $countSql = "SELECT COUNT(*) FROM {$this->tableName} {$where}";
        if ($args) {
            $totalItems = (int) $wpdb->get_var($wpdb->prepare($countSql, $args));
        } else {
            $totalItems = (int) $wpdb->get_var($countSql);
        }

        $viewsTable = $wpdb->prefix . 'story_chapter_views';
        $itemsSql = "SELECT c.id, c.story_id, c.chapter_number, c.title, c.status,
                             c.created_at, c.updated_at, COALESCE(v.total_views, 0) AS views
                      FROM {$this->tableName} c
                      LEFT JOIN {$viewsTable} v ON v.chapter_id = c.id
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
