<?php
require_once plugin_dir_path(__DIR__) . 'includes/Product_List_Table.php';
require_once plugin_dir_path(__DIR__) . 'includes/handle_syn_sheet.php';

$table = new Product_List_Table();

if (isset($_POST['sync_toggle_auto']) && check_admin_referer('sync_action', 'sync_nonce')) {
    $opts = sync_product_get_options();

    $opts['auto_sync'] = isset($_POST['auto_sync']) ? 1 : 0;
    update_option('sync_options', $opts);

    $msg = $opts['auto_sync']
        ? ' Đã bật tự động đồng bộ hàng ngày.'
        : ' Đã tắt tự động đồng bộ hàng ngày.';

    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($msg) . '</p></div>';
}

if (isset($_POST['sync_run']) && check_admin_referer('sync_action', 'sync_nonce')) {
    $res = sync_products();
    $message = sprintf(
        'Đồng bộ xong: <b>%d thêm mới</b>, <b>%d cập nhật</b>, <b>%d giống nhau</b>, <b>%d lỗi</b>.',
        $res['inserted'],
        $res['updated'],
        $res['skipped'],
        $res['failed']
    );

    if (!empty($res['errs'])) {
        $message .= '<br><b>Các dòng lỗi:</b><pre style="background:#f8f8f8;padding:6px;border:1px solid #ccc;">' .
            esc_html(print_r($res['errs'], true)) . '</pre>';
    }

    echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
}

$table->prepare_items();
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Danh sách sản phẩm đã đồng bộ</h1>
    <hr class="wp-header-end">

    <form method="post">
        <?php wp_nonce_field('sync_action', 'sync_nonce'); ?>

        <?php
        $opts = sync_product_get_options();
        $is_auto = !empty($opts['auto_sync']);
        ?>

        <div style="display:flex;align-items:center;gap:10px;margin:10px 0;">
            <label class="switch">
                <input type="checkbox" name="auto_sync" value="1" <?php checked($is_auto, true); ?> />
                <span class="slider round"></span>
            </label>
            <span><b>Tự động đồng bộ mỗi ngày</b></span>
        </div>

        <?php submit_button('Lưu thiết lập', 'secondary', 'sync_toggle_auto', false); ?>

        <hr>

        <div style="margin: 15px 0;">
            <?php submit_button('Đồng bộ ngay', 'primary', 'sync_run', false); ?>
            <a href="<?php echo esc_url(add_query_arg(['page' => $_REQUEST['page']])); ?>" class="button">Làm mới</a>
        </div>

        <p><b>Google Sheet:</b>
            <code><?php
                    echo esc_html($opts['sheet_id'] ?: 'Chưa cấu hình');
                    ?></code>
        </p>

        <hr>

        <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />

        <?php $table->display(); ?>
    </form>
</div>

<style>
    .wp-list-table .column-price {
        text-align: right;
        width: 100px;
    }

    .wp-list-table .column-category {
        width: 150px;
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Switch cron*/
    .switch {
        position: relative;
        display: inline-block;
        width: 56px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cfcfcf;
        transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 34px;
        box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.2);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .switch input:checked+.slider {
        background-color: #2196f3;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .switch input:checked+.slider:before {
        transform: translateX(26px);
    }

    .switch:hover .slider {
        box-shadow: inset 0 0 8px rgba(33, 150, 243, 0.3);
    }

    .slider.round {
        border-radius: 34px;
    }
</style>