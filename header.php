<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <!-- HEADER -->
  <header class="w-full">
    <nav class="bg-neutral-primary">
      <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-4">

        <div class="relative flex items-center">
          <div class="absolute w-[90px] h-[68px] rounded-b-lg"
            style="border-left: 0.5px solid #EEE1E1; border-right: 0.5px solid #EEE1E1; border-bottom: 2px solid #A31D22;">
          </div>

          <div class="pl-3 relative z-10">
            <?php
            $header_logo = get_theme_mod('header_logo');

            if ($header_logo) : ?>
              <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url($header_logo); ?>"
                  class="h-10"
                  alt="<?php bloginfo('name'); ?>" />
              </a>
            <?php elseif (function_exists('the_custom_logo') && has_custom_logo()) : ?>
              <?php the_custom_logo(); ?>
            <?php else : ?>
              <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/LOGO-Gia-phan1.svg'); ?>"
                  class="h-10"
                  alt="<?php bloginfo('name'); ?>" />
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- MENU DESKTOP -->
        <nav class="bg-neutral-secondary-soft hidden sm:block font-hd text-base">
          <div class="px-4 py-3">
            <div class="flex items-center">
              <?php
              wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex flex-row font-medium mt-0 space-x-6 text-sm',
                'fallback_cb'    => false,
              ]);
              ?>
            </div>
          </div>
        </nav>

        <div class="flex items-center gap-3">
          <?php
          $phone = get_theme_mod('header_phone', '0123 456 789');
          ?>
          <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"
            class="text-sm text-white font-semibold no-underline bg-main rounded-3xl py-2 px-4 whitespace-nowrap">
            <?php echo esc_html($phone); ?>
          </a>

          <button type="button" class="text-sm font-medium text-fg-brand no-underline">
            <svg class="w-6 h-6 text-main" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
          </button>
        </div>

      </div>
    </nav>

    <!-- MENU MOBILE -->
    <nav class="bg-neutral-secondary-soft border-y border-default block sm:hidden font-hd">
      <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex items-center justify-center">
          <?php
          wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'flex flex-row font-medium mt-0 space-x-6 text-sm',
            'fallback_cb'    => false,
          ]);
          ?>
        </div>
      </div>
    </nav>
  </header>