<?php
// Đảm bảo mã này được đặt trong hàm callback của register_activation_hook

function shop_member_install()
{
  global $wpdb;

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  $table_name =  "shop_member";
  $table_feedback = $wpdb->prefix . "user_feedbacks";

  $sql = "CREATE TABLE $table_name (
      ID bigint(20) NOT NULL AUTO_INCREMENT,
      name text NOT NULL,
      sdt varchar(20)  NULL,
      dia_chi varchar(500)  NULL,
      gioi_tinh int  NULL,
      key_uuid varchar(100),
      path_QR text ,
      bib_photo longtext ,
      signature_data longtext ,
      email varchar(45) ,
      pdf_path longtext,
      PRIMARY KEY (ID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

  $sql2 = "CREATE TABLE $table_feedback (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name nvarchar(200) NOT NULL,
        rating int(2) NOT NULL DEFAULT 0,             
        message text NULL,    
        status  TINYINT default 0,                         
        created_at datetime DEFAULT CURRENT_TIMESTAMP, 
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

  dbDelta($sql2);
  dbDelta($sql);
}

register_activation_hook(__FILE__, 'shop_member_install');
