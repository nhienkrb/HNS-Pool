<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    
    <!-- CSS BỔ SUNG ĐỂ ĐỊNH DẠNG HEADER VÀ MENU -->
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .site-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Tiêu đề trang */
        .site-header h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        /*  MENU LIST (UL) */
        .main-menu-list {
            list-style: none; 
            margin: 0;
            padding: 0;
            display: flex; 
        }

        /* Menu Item (LI) */
        .main-menu-list li {
            margin-left: 15px; 
        }

        /* Menu Link (A) */
        .main-menu-list a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            transition: background-color 0.3s;
            border-radius: 4px;
        }

        .main-menu-list a:hover,
        .main-menu-list a:focus {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .site-header {
                flex-direction: column; 
                align-items: flex-start;
            }
            .site-header h1 {
                margin-bottom: 10px;
            }
            .main-menu-list {
                flex-direction: column;
                width: 100%;
            }
            .main-menu-list li {
                margin-left: 0;
                margin-bottom: 5px;
            }
            .main-menu-list a {
                display: block; 
                width: 100%;
                text-align: left;
            }
        }
    </style>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="main-header" class="site-header">
        <h1><?php bloginfo('name'); ?></h1>
        
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary', 
                'container'      => 'div', 
                'container_class'=> 'main-menu-container', 
                'menu_class'     => 'main-menu-list', 
                'fallback_cb'    => false, 
            ) );
            ?>
        </nav>
    </header>
