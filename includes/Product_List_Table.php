<?php
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Product_List_Table extends WP_List_Table
{
    private $table_data;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'product',
            'plural'   => 'products',
            'ajax'     => false,
        ]);
    }

    function get_columns()
    {
        return [
            'cb'          => '<input type="checkbox" />',
            'id'          => "ID",
            'external_id' => "External ID",
            'name'        => "Tên sản phẩm",
            'category'    => "Danh mục",
            'price'       => "Giá",
            'updated_at'  => "Cập nhật",
            'created_at'  => "Tạo lúc",
            'actions'     => "Thao tác",
        ];
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'external_id':
            case 'name':
            case 'category':
            case 'price':
            case 'updated_at':
            case 'created_at':
                return esc_html($item[$column_name]);

            case 'actions':
                $json_data = htmlspecialchars(json_encode($item, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                $id = esc_attr($item['id']);

                return sprintf(
                    '<button type="button" class="button edit-product" data-product="%s" title="%s">✏️</button>
                     <button type="button" class="button delete-product" data-id="%s" title="%s">🗑️</button>',
                    $json_data,
                    esc_attr__('Sửa sản phẩm', 'gsync'),
                    $id,
                    esc_attr__('Xóa sản phẩm', 'sync')
                );

            default:
                return '';
        }
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            esc_attr($item['id'])
        );
    }

    protected function get_sortable_columns()
    {
        return [
            'id'          => ['id', false],
            'external_id' => ['external_id', false],
            'name'        => ['name', false],
            'category'    => ['category', false],
            'price'       => ['price', false],
            'updated_at'  => ['updated_at', false],
            'created_at'  => ['created_at', false],
        ];
    }

    function usort_reorder($a, $b)
    {
        $orderby = $_GET['orderby'] ?? 'id';
        $order   = $_GET['order'] ?? 'desc';
        $result  = strcmp($a[$orderby], $b[$orderby]);
        return ($order === 'asc') ? $result : -$result;
    }

    public function extra_tablenav($which)
    {
        if ($which === "top") {
            $categories = $this->getCategories();
            $selected_category = isset($_REQUEST['category_filter'])
                ? sanitize_text_field($_REQUEST['category_filter'])
                : '';
?>
            <div class="alignleft actions">
                <select name="category_filter">
                    <option value="">-- Tất cả danh mục --</option>
                    <?php
                    foreach ($categories as $cat) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            esc_attr($cat),
                            selected($selected_category, $cat, false),
                            esc_html(ucfirst($cat))
                        );
                    }
                    ?>
                </select>
                <?php submit_button('Lọc', '', 'filter_action', false); ?>
                <button type="button" class="button button-primary" id="btn-add-product">➕ Thêm mới</button>
            </div>
<?php
        }
    }

    public function prepare_items()
    {
        $this->table_data = $this->get_table_data();

        $columns  = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable, 'name'];

        usort($this->table_data, [$this, 'usort_reorder']);

        $per_page     = $this->get_items_per_page('products_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items  = count($this->table_data);

        $this->table_data = array_slice(
            $this->table_data,
            (($current_page - 1) * $per_page),
            $per_page
        );

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);

        $this->items = $this->table_data;
    }

    private function get_table_data()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'syn_products';

        $where = [];
        $params = [];

        if (!empty($_REQUEST['category_filter'])) {
            $where[] = 'category = %s';
            $params[] = sanitize_text_field($_REQUEST['category_filter']);
        }

        $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $query = $wpdb->prepare("SELECT * FROM {$table} {$where_sql} ORDER BY id DESC", $params);

        return $wpdb->get_results($query, ARRAY_A);
    }

    private function getCategories()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'syn_products';
        return $wpdb->get_col("SELECT DISTINCT category FROM {$table} ORDER BY category ASC");
    }
}
?>
