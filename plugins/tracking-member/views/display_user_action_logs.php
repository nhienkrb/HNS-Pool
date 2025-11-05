<?php
require_once plugin_dir_path(__DIR__) . 'includes/Tracking_List_Table.php';
$tracking_member = new Tracking_List_Table();
$tracking_member->prepare_items();
?>

<div class="wrap">
    <h1>Lịch sử hoạt động</h1>
    <form method="post" autocomplete="off" id="tracking-list-form">
           <input type="hidden" name="page" value="user-action-logs" /> 
        <?php $tracking_member->search_box('Tìm kiếm Logs', 'log-search-input'); ?>
        <?php $tracking_member->display(); ?>
    </form>
</div>