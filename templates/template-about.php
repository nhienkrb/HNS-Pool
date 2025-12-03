<?php

/**
 * Template Name: Về chúng tôi
 */; ?>

<?php get_header(); ?>

<main>
  <!-- SECTION 1: BANNER -->
  <?php
  $about_banner_image = get_theme_mod(
    'about_banner_image',
    get_template_directory_uri() . '/assets/img/BANNER-about.svg'
  );
  ?>

  <section>
    <div>
      <img src="<?php echo esc_url($about_banner_image); ?>"
        class="w-full object-cover"
        alt="">
    </div>
  </section>


  <!-- SECTION 2: Breadcrumb -->
  <section>
    <nav class="text-center font-hd space-x-2 my-8">
      <a href="#" class="text-main-title font-semibold text-base">Trang Chủ /</a>
      <a href="#" class="text-[#5C5C5C]">Về Gia Phan</a>
    </nav>
  </section>

  <?php
  $about_page_heading_label = get_theme_mod('about_page_heading_label', 'Về chúng tôi');
  $about_page_heading_title = get_theme_mod('about_page_heading_title', 'NHÔM KÍNH GIA PHAN – KIẾN TẠO KHÔNG GIAN SỐNG BỀN VỮNG');

  $about_page_intro_p1 = get_theme_mod('about_page_intro_p1', '');
  $about_page_intro_p2 = get_theme_mod('about_page_intro_p2', '');
  $about_page_body_p1  = get_theme_mod('about_page_body_p1', '');
  $about_page_body_p2  = get_theme_mod('about_page_body_p2', '');
  $about_page_body_p3  = get_theme_mod('about_page_body_p3', '');

  $about_page_image_1 = get_theme_mod('about_page_image_1', get_template_directory_uri() . '/assets/img/about1.svg');
  $about_page_image_2 = get_theme_mod('about_page_image_2', get_template_directory_uri() . '/assets/img/about1.svg');
  ?>

  <!-- SECTION: VỀ CHÚNG TÔI -->
  <section>
    <div class="max-w-7xl mx-auto px-4 font-hd space-y-12">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start mx-5">

        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
            <h2 class="text-main font-playfair text-3xl">
              <?php echo esc_html($about_page_heading_label); ?>
            </h2>
          </div>

          <h2 class="text-main-title font-bold text-2xl md:text-3xl leading-[130%] uppercase">
            <?php echo esc_html($about_page_heading_title); ?>
          </h2>

          <?php if ($about_page_intro_p1) : ?>
            <p class="text-[#555] leading-[160%] text-sm md:text-base">
              <?php echo wp_kses_post($about_page_intro_p1); ?>
            </p>
          <?php endif; ?>

          <?php if ($about_page_intro_p2) : ?>
            <p class="text-[#555] leading-[160%] text-sm md:text-base">
              <?php echo wp_kses_post($about_page_intro_p2); ?>
            </p>
          <?php endif; ?>
        </div>

        <div class="flex justify-center lg:justify-end">
          <div class="relative w-full max-w-[480px]">
            <div class="hidden sm:block absolute -top-5 -right-6 w-3/4 h-3/4 bg-main rounded-xl"></div>

            <div class="relative rounded-xl overflow-hidden shadow-md">
              <img src="<?php echo esc_url($about_page_image_1); ?>"
                alt="Nhà xưởng Gia Phan"
                class="w-full h-auto object-cover">
            </div>
          </div>
        </div>

      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start mx-10">

        <div class="flex justify-center lg:justify-start order-1 lg:order-1">
          <div class="relative w-full max-w-[480px]">
            <div class="hidden sm:block absolute -top-5 -left-6 w-3/4 h-3/4 bg-main rounded-xl"></div>

            <div class="relative rounded-xl overflow-hidden shadow-md">
              <img src="<?php echo esc_url($about_page_image_2); ?>"
                alt="Công trình Gia Phan"
                class="w-full h-auto object-cover">
            </div>
          </div>
        </div>

        <div class="space-y-4 order-2 lg:order-2">
          <?php if ($about_page_body_p1) : ?>
            <p class="text-[#555] leading-[160%] text-sm md:text-base">
              <?php echo wp_kses_post($about_page_body_p1); ?>
            </p>
          <?php endif; ?>

          <?php if ($about_page_body_p2) : ?>
            <p class="text-[#555] leading-[160%] text-sm md:text-base">
              <?php echo wp_kses_post($about_page_body_p2); ?>
            </p>
          <?php endif; ?>

          <?php if ($about_page_body_p3) : ?>
            <p class="text-[#555] leading-[160%] text-sm md:text-base">
              <?php echo wp_kses_post($about_page_body_p3); ?>
            </p>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </section>


  <?php
  $about_vmv_bg_image = get_theme_mod(
    'about_vmv_bg_image',
    get_template_directory_uri() . '/assets/img/banner-tam-nhin.svg'
  );

  $about_vmv_vision_title = get_theme_mod('about_vmv_vision_title', 'Tầm nhìn');
  $about_vmv_vision_text  = get_theme_mod('about_vmv_vision_text', '');

  $about_vmv_mission_title = get_theme_mod('about_vmv_mission_title', 'Sứ mệnh');
  $about_vmv_mission_items_raw = get_theme_mod('about_vmv_mission_items', '');
  $about_vmv_mission_items = array_filter(array_map('trim', explode("\n", $about_vmv_mission_items_raw)));

  $about_vmv_values_title = get_theme_mod('about_vmv_values_title', 'Giá trị cốt lõi');
  $about_vmv_values_items_raw = get_theme_mod('about_vmv_values_items', '');
  $about_vmv_values_items = array_filter(array_map('trim', explode("\n", $about_vmv_values_items_raw)));
  ?>

  <!-- SECTION: TẦM NHÌN - SỨ MỆNH - GIÁ TRỊ CỐT LÕI -->
  <section class="relative mt-30">
    <div class="w-auto h-[350px] bg-cover bg-center"
      style="background-image: url('<?php echo esc_url($about_vmv_bg_image); ?>');">
    </div>

    <div>
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-start -mt-20 md:-mt-50">

          <!-- CARD 1: TẦM NHÌN -->
          <article class="bg-white rounded-3xl shadow-[0_10px_24px_rgba(0,0,0,0.06)] px-6 py-6 md:px-8 md:py-8 flex flex-col gap-4">
            <div>
              <!-- Icon card 1: bạn chỉnh lại path đúng file trong theme -->
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-tam-nhin.svg'); ?>"
                alt=""
                class="w-[130px] h-auto object-contain">
            </div>

            <div class="space-y-2">
              <h3 class="font-hd font-bold text-lg md:text-2xl uppercase text-main-title">
                <?php echo esc_html($about_vmv_vision_title); ?>
              </h3>
              <?php if ($about_vmv_vision_text) : ?>
                <p class="text-sm md:text-base leading-[160%] text-[#555]">
                  <?php echo wp_kses_post($about_vmv_vision_text); ?>
                </p>
              <?php endif; ?>
            </div>
          </article>

          <!-- CARD 2: SỨ MỆNH -->
          <article class="bg-white rounded-3xl shadow-[0_10px_24px_rgba(0,0,0,0.06)] px-6 py-6 md:px-8 md:py-8 flex flex-col gap-4">
            <div>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-su-menh.svg'); ?>"
                alt=""
                class="w-[130px] h-auto object-contain">
            </div>

            <div class="space-y-2">
              <h3 class="font-hd font-bold text-lg md:text-2xl uppercase text-main-title">
                <?php echo esc_html($about_vmv_mission_title); ?>
              </h3>
              <?php if (! empty($about_vmv_mission_items)) : ?>
                <ul class="text-sm md:text-base leading-[160%] text-[#555] list-disc pl-5 space-y-1">
                  <?php foreach ($about_vmv_mission_items as $item) : ?>
                    <li><?php echo esc_html($item); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </article>

          <!-- CARD 3: GIÁ TRỊ CỐT LÕI -->
          <article class="bg-white rounded-3xl shadow-[0_10px_24px_rgba(0,0,0,0.06)] px-6 py-6 md:px-8 md:py-8 flex flex-col gap-4">
            <div>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/iocn-gia-tri.svg'); ?>"
                alt=""
                class="w-[130px] h-auto object-contain">
            </div>

            <div class="space-y-2">
              <h3 class="font-hd font-bold text-lg md:text-2xl uppercase text-main-title">
                <?php echo esc_html($about_vmv_values_title); ?>
              </h3>
              <?php if (! empty($about_vmv_values_items)) : ?>
                <ul class="text-sm md:text-base leading-[160%] text-[#555] list-disc pl-5 space-y-1">
                  <?php foreach ($about_vmv_values_items as $item) : ?>
                    <li><?php echo esc_html($item); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </article>

        </div>
      </div>
    </div>
  </section>


  <?php
  $about_cert_label = get_theme_mod('about_cert_label', 'Thành tích');
  $about_cert_title_raw = get_theme_mod('about_cert_title', "CHỨNG NHẬN VÀ GIẢI THƯỞNG\nCỦA GIA PHAN");
  $about_cert_title = nl2br(esc_html($about_cert_title_raw));

  $about_cert_bg  = get_theme_mod('about_cert_bg', get_template_directory_uri() . '/assets/img/decor.svg');
  $about_cert_img1 = get_theme_mod('about_cert_image_1', get_template_directory_uri() . '/assets/img/chung-nhan2.svg');
  $about_cert_img2 = get_theme_mod('about_cert_image_2', get_template_directory_uri() . '/assets/img/chung-nhan1.svg');
  $about_cert_img3 = get_theme_mod('about_cert_image_3', get_template_directory_uri() . '/assets/img/chung-nhan3.svg');
  ?>

  <section class="py-16 bg-[#FDFFFA]">
    <div class="max-w-7xl mx-auto px-4 font-hd">

      <!-- TITLE -->
      <div class="text-center space-y-3">
        <div class="flex items-center justify-center gap-3">
          <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
          <span class="text-main font-playfair text-3xl">
            <?php echo esc_html($about_cert_label); ?>
          </span>
        </div>
        <h2 class="text-main-title font-bold text-xl md:text-3xl leading-[130%] uppercase">
          <?php echo $about_cert_title; // đã nl2br ở trên 
          ?>
        </h2>
      </div>

      <!-- BOX CHỨNG NHẬN -->
      <div class="mt-10 bg-cover bg-center bg-no-repeat"
        style="background-image: url('<?php echo esc_url($about_cert_bg); ?>');">

        <div class="relative grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10 items-end justify-items-center">

          <div class="max-w-[280px]">
            <img src="<?php echo esc_url($about_cert_img1); ?>"
              alt="Chứng nhận 1"
              class="w-full h-auto object-contain rounded-[8px] md:rounded-[10px]">
          </div>

          <div class="max-w-[384px] md:max-w-[380px]">
            <img src="<?php echo esc_url($about_cert_img2); ?>"
              alt="Chứng nhận 2"
              class="w-full h-auto object-contain rounded-[8px] md:rounded-[10px]">
          </div>

          <div class="max-w-[280px]">
            <img src="<?php echo esc_url($about_cert_img3); ?>"
              alt="Chứng nhận 3"
              class="w-full h-auto object-contain rounded-[8px] md:rounded-[10px]">
          </div>

        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>