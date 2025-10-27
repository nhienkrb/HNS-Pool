<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH  . "wp-admin/includes/class-wp-list-table.php");
}

class My_List_Table extends WP_List_Table
{
    private $table_data;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'shop_members',
            'plural'   => 'shop_member',
            'ajax'     => false
        ]);
    }

    function get_columns()
    {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'ID'          => "ID",
            'name'         => "Tên",
            'dia_chi'   => "Địa Chỉ",
            'gioi_tinh'        => "Giới Tính",
            'sdt'        => "SĐT",
            'actions'   => 'Thao Tác'

        );
        return $columns;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'ID':
            case 'name':
            case 'sdt':
            case 'dia_chi':
                return esc_html($item[$column_name]);
            case 'gioi_tinh':
                return $item['gioi_tinh'] ? 'Nam' : 'Nữ';
            case 'actions':
                return sprintf(
                    '<button type="button" class="button edit-member" data-member="%s">✏️ Sửa</button> 
                     <button type="button" class="button delete-member" data-id="%d">🗑️ Xóa</button>',
                    esc_attr(json_encode($item)),
                    $item['ID']
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
            $item['ID'] // Sử dụng khóa chính (ID) của bảng
        );
    }

    protected function get_sortable_columns()
    {
        $sort_table_columns = array(
            'ID' => array('ID', false),
            'name' => array('name', false),
            'dia_chi' => array('dia_chi', false),
            'gioi_tinh' => array('gioi_tinh', false),
            'sdt' => array('sdt', false)


        );
        return $sort_table_columns;
    }

    function usort_reorder($a, $b)
    {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID';

        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';

        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order === 'asc') ? $result : -$result;
    }


    public function extra_tablenav($which)
    {
        if ($which == "top") {
            $gioi_tinh = isset($_REQUEST['gioi_tinh_filter']) ? $_REQUEST['gioi_tinh_filter'] : '';
            $dia_chi = isset($_REQUEST['dia_chi_filter']) ? $_REQUEST['dia_chi_filter'] : '';
?>
            <div class="alignleft actions">
                <!-- Bộ lọc giới tính -->
                <select name="gioi_tinh_filter">
                    <option value="">-- Tất cả giới tính --</option>
                    <option value="1" <?php selected($gioi_tinh, '1'); ?>>Nam</option>
                    <option value="0" <?php selected($gioi_tinh, '0'); ?>>Nữ</option>
                </select>

                <!-- Bộ lọc địa chỉ -->
                <select name="dia_chi_filter">
                    <option value="">-- Tất cả địa chỉ --</option>
                    <option value="hcm" <?php selected($dia_chi, 'hcm'); ?>>HCM</option>
                    <option value="hn" <?php selected($dia_chi, 'hn'); ?>>Hà Nội</option>
                    <option value="dn" <?php selected($dia_chi, 'dn'); ?>>Đà Nẵng</option>
                </select>

                <?php submit_button('Lọc', '', 'filter_action', false); ?>
            </div>
<?php
        }
    }



    public function prepare_items()
    {
        // Search
        if (isset($_POST['s'])) {
            $this->table_data = $this->get_table_data(sanitize_text_field($_POST['s']));
        } else {
            $this->table_data = $this->get_table_data();
        }


        $gioi_tinh = isset($_REQUEST['gioi_tinh_filter']) ? sanitize_text_field($_REQUEST['gioi_tinh_filter']) : '';
        $dia_chi = isset($_REQUEST['dia_chi_filter']) ? sanitize_text_field($_REQUEST['dia_chi_filter']) : '';

        $this->table_data  = $this->get_table_data_filter($gioi_tinh,$dia_chi);

        //data
        $columns = $this->get_columns();
        $hidden =  array();

        $sortable = $this->get_sortable_columns();
        $primary  = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        usort($this->table_data, array(&$this, 'usort_reorder'));

        /* pagination */
        $per_page = $this->get_items_per_page('elements_per_page', 2);
        $current_page = $this->get_pagenum();
        $total_items = count($this->table_data);

        $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, // total number of items
            'per_page'    => $per_page, // items to show on a page
            'total_pages' => ceil($total_items / $per_page) // use ceil to round up
        ));

        $this->items = $this->table_data;
    }
    // Get table data
    private function get_table_data($search = '')
    {
        global $wpdb;

        $table = 'shop_member';

        if (!empty($search)) {
            return $wpdb->get_results(
                "SELECT * from {$table} WHERE name Like '%{$search}%' OR dia_chi Like '%{$search}%' OR sdt Like '%{$search}%'",
                ARRAY_A
            );
        } else {
            return $wpdb->get_results(
                "SELECT * from {$table}",
                ARRAY_A
            );
        }
    }

    private function get_table_data_filter($gioi_tinh = '', $dia_chi = '')
    {
        global $wpdb;
        $table = 'shop_member';

        $sql = "SELECT * FROM {$table} WHERE 1=1";

        if (!empty($gioi_tinh)) {
            $sql .= $wpdb->prepare(" AND gioi_tinh = %s", $gioi_tinh);
        }

        if (!empty($dia_chi)) {
            $sql .= $wpdb->prepare(" AND dia_chi LIKE %s", '%' . $wpdb->esc_like($dia_chi) . '%');
        }

        return $wpdb->get_results($sql, ARRAY_A);
    }


    function get_bulk_actions()
    {
        $actions = array(
            'delete_all'    => __('Xóa', 'supporthost-admin-table'),
            'draft_all' => __('Chuyển Sang thùng rác', 'supporthost-admin-table')
        );
        return $actions;
    }
}
