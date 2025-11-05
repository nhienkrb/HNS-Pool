<?php

class Logger_Loader
{
    public static function init()
    {
        require_once plugin_dir_path(__FILE__) . 'Logger_Utils.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_DB.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_Auth.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_Posts.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_Categories.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_Taxonomy.php';
        require_once plugin_dir_path(__FILE__) . 'Logger_Menu.php';


        register_activation_hook(__FILE__, ['Logger_DB', 'create_table']);

        new Logger_Utils();
        new Logger_Auth();
        new Logger_Posts();
        new Logger_Categories();
        new Logger_Taxonomy();
        new Logger_Menu();
        error_log('Logger_loader::init() chạy');
    }
}
