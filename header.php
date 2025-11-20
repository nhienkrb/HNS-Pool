<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header>

    <!-- TOP NAV -->
    <nav class="bg-[#F6FFFF] border-gray-200">
      <div class="flex flex-wrap justify-between items-center mx-auto container p-3 h-[77px]">

        <!-- Logo -->
        <a href="<?php echo home_url('/'); ?>" class="flex items-center">
          <img
            src="<?= esc_url(get_theme_mod('logo_image')); ?>"
            alt="Logo"
            class="w-[97px] h-[58px] object-contain" />
        </a>

        <!-- Search -->
        <div class="flex items-center space-x-6 rtl:space-x-reverse">
          <div class="relative w-full max-w-2xl mx-auto">
            <input type="text"
              placeholder="Tìm kiếm ..."
              class="w-[461px] h-[43px] pl-6 pr-14 rounded-full border border-blue-400 focus:ring-2 focus:ring-blue-300 outline-none" />

            <button
              class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center">
              <img
                src="<?php echo get_template_directory_uri(); ?>/assets/images/search-icon.svg"
                alt="search">
            </button>
          </div>
        </div>

        <!-- Hotline -->
        <div class="flex items-center space-x-6 rtl:space-x-reverse">
          <button
            class="w-[174px] h-[38px] flex justify-center items-center border rounded-3xl text-sm text-[#161A47]">
            <img
              src="<?php echo get_template_directory_uri(); ?>/assets/images/phone-icon.svg"
              alt="phone-icon">
            <span class="ml-2"><?= esc_html(get_theme_mod('phone')); ?></span>
          </button>
        </div>

      </div>
    </nav>
    <nav class="bg-[#0D4A9A]">
      <div class="container px-4 py-3 mx-auto">
        <div class="flex items-center justify-center">

          <?php if (has_nav_menu('primary_navigation')) : ?>
            <?php
            wp_nav_menu([
              'theme_location' => 'primary_navigation',
              'menu_class'     => 'flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm',
              'container'      => false,
              'fallback_cb'    => false,
              'depth'          => 1,
            ]);
            ?>

          <?php else : ?>

            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
              <li><a href="<?php echo home_url('/'); ?>" class="text-white">Trang chủ</a></li>
              <li><a href="#" class="text-white">Giới thiệu</a></li>
              <li><a href="#" class="text-white">Hồ bơi</a></li>
              <li><a href="#" class="text-white">Composite</a></li>
              <li><a href="#" class="text-white">Tin tức</a></li>
              <li><a href="#" class="text-white">Dự án tiêu biểu</a></li>
              <li><a href="#" class="text-white">Góc tư vấn</a></li>
              <li><a href="#" class="text-white">Liên hệ</a></li>
            </ul>

          <?php endif; ?>

        </div>
      </div>
    </nav>


  </header>