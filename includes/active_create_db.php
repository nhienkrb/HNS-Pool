<?php 
// Đảm bảo mã này được đặt trong hàm callback của register_activation_hook

function shop_member_install() {
    global $wpdb;
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' ); 

    $table_name =  "shop_member";
    
    $sql = "CREATE TABLE $table_name (
      ID bigint(20) NOT NULL AUTO_INCREMENT,
      name text NOT NULL,
      sdt varchar(20) NOT NULL,
      dia_chi varchar(500) NOT NULL,
      gioi_tinh int NOT NULL,
      PRIMARY KEY (ID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    dbDelta( $sql ); 
}

register_activation_hook(__FILE__, 'shop_member_install');
?>