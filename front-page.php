<?php

/**
 * Template Name: Trang Chủ
 */; ?>
<?php get_header(); ?>

<!-- HERO / BANNER -->
<section class="mt-4">
  <div class="container mx-auto px-4">
    <div class="relative rounded-2xl overflow-hidden">
      <div class="swiper hero-swiper">
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <div class="relative">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/BANNER-about.svg" alt="<?php echo get_template_directory_uri(); ?>/assets" class="w-full h-auto">
              <div class="flex ">
                <div class="absolute bottom-0 left-0 w-25 pl-1 pt-2  md:w-[450px] md:pt-5 md:pr-5 bg-white rounded-len rounded-tr-xl 
               flex  flex-row items-center justify-between ">
                  <h1 class="text-main font-bold leading-tight md:text-3xl text-[10px] z-100">
                    NHÀ VĂN PHÒNG & NHÀ XƯỞNG CÔNG TY TNHH FREEVIEW VIỆT NAM
                  </h1>
                  <div
                    class="flex items-center justify-center w-3  h-3  sm:w-10 sm:h-10 border border-main rounded-full bg-white/80 z-100">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="swiper-slide">
            <div class="relative">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner-about.svg" alt="<?php echo get_template_directory_uri(); ?>/assets" class="w-full h-auto">
              <div class="flex ">
                <div class="absolute bottom-0 left-0 w-25 pl-1 pt-2  md:w-[450px] md:pt-5 md:pr-5 bg-white rounded-len rounded-tr-xl 
               flex  flex-row items-center justify-between ">
                  <h1 class="text-main font-bold leading-tight md:text-3xl text-[10px] z-100">
                    LONGWELL - Đồng Nai
                  </h1>
                  <div
                    class="flex items-center justify-center w-3  h-3  sm:w-10 sm:h-10 border border-main rounded-full bg-white/80 z-100">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class=" flex gap-3 absolute left-[38%] bottom-[2%] mb-1">
        <button class="hero-prev z-30  cursor-pointer
               w-5 h-5 sm:w-10 sm:h-10 rounded-full 
               bg-opacity-25  bg-black/30  text-white
               flex items-center justify-center shadow-md
               hover:bg-main hover:border-main hover:text-white transition">
          <i class="fa-solid fa-angle-left text-xs sm:text-sm"></i>
        </button>
        <button class="hero-prev z-30 
               w-5 h-5 sm:w-10 sm:h-10 rounded-full  cursor-pointer
               bg-opacity-25  bg-black/30  text-white
               flex items-center justify-center shadow-md
               hover:bg-main hover:border-main hover:text-white transition">
          <i class="fa-solid fa-angle-right text-xs sm:text-sm"></i>
        </button>
      </div>

    </div>

  </div>
</section>

<!-- SECTION 2: VỀ CHÚNG TÔI -->
<section class="mt-10">
  <div class="container mx-auto px-4 py-12 md:px-8 lg:px-20 font-hd">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start">

      <?php
      $about_label       = get_theme_mod('about_label', 'Về Chúng tôi');
      $about_title       = get_theme_mod('about_title', 'Nhôm Kính Gia Phan - Kiến tạo không gian sống bền vững');
      $about_content     = get_theme_mod('about_content', '');
      $about_button_text = get_theme_mod('about_button_text', 'Xem Thêm');
      $about_button_url  = get_theme_mod('about_button_url', '#');
      ?>

      <div class="space-y-2 md:border-r-2 border-[#1F050614] md:pr-8 pb-6 md:pb-0">
        <div class="flex items-center gap-3">
          <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
          <h2 class="text-main font-medium text-2xl font-playfair">
            <?php echo esc_html($about_label); ?>
          </h2>
        </div>
        <div class="text-[#0F3857] font-semibold text-2xl md:text-3xl leading-[130%] uppercase">
          <h1><?php echo esc_html($about_title); ?></h1>
        </div>
      </div>

      <div class="space-y-4 text-sm md:text-base">
        <?php if ($about_content) : ?>
          <p class="line-clamp-3">
            <?php echo wp_kses_post($about_content); ?>
          </p>
        <?php endif; ?>

        <?php if ($about_button_text && $about_button_url) : ?>
          <a href="<?php echo esc_url($about_button_url); ?>"
            class="cursor-pointer inline-flex items-center justify-center px-5 py-3 border-[1.5px] border-main rounded-md font-medium leading-5 hover:bg-main hover:text-white transition-colors">
            <?php echo esc_html($about_button_text); ?>
          </a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<!-- SECTION 3: HÌNH + SỐ LIỆU -->
<?php
$stats_main_image = get_theme_mod('stats_main_image', get_template_directory_uri() . '/assets/img/home1.svg');
$stats_logo_image = get_theme_mod('stats_logo_image', get_template_directory_uri() . '/assets/img/LOGO-Giaphan1-outline.svg');

$stats_1_number = get_theme_mod('stats_1_number', '50+');
$stats_1_label  = get_theme_mod('stats_1_label', 'Khách hàng');

$stats_2_number = get_theme_mod('stats_2_number', '20+');
$stats_2_label  = get_theme_mod('stats_2_label', 'Nhân sự');

$stats_3_number = get_theme_mod('stats_3_number', '18+');
$stats_3_label  = get_theme_mod('stats_3_label', 'Đối tác');

$stats_4_number = get_theme_mod('stats_4_number', '15+');
$stats_4_label  = get_theme_mod('stats_4_label', 'Năm kinh nghiệm');
?>

<section class="mt-4">
  <div class="bg-linear-to-r from-[#540909] to-[#971414] py-8">
    <div class="w-full mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

        <div>
          <img src="<?php echo esc_url($stats_main_image); ?>"
            class="w-full h-auto object-cover"
            alt="">
        </div>

        <div class="relative text-white">
          <div class="grid grid-cols-2 border-white/20 sm:px-10 sm:pr-40 md:pl-10 jo">
            <div class="flex flex-col items-center justify-center py-6 border-b border-white/20 border-r">
              <h1 class="text-4xl md:text-5xl font-semibold">
                <?php echo esc_html($stats_1_number); ?>
              </h1>
              <p class="text-sm md:text-lg">
                <?php echo esc_html($stats_1_label); ?>
              </p>
            </div>

            <div class="flex flex-col items-center justify-center py-6 border-b border-white/20">
              <h1 class="text-4xl md:text-5xl font-semibold">
                <?php echo esc_html($stats_2_number); ?>
              </h1>
              <p class="text-sm md:text-lg">
                <?php echo esc_html($stats_2_label); ?>
              </p>
            </div>

            <div class="flex flex-col items-center justify-center py-6 border-r border-white/20">
              <h1 class="text-4xl md:text-5xl font-semibold">
                <?php echo esc_html($stats_3_number); ?>
              </h1>
              <p class="text-sm md:text-lg">
                <?php echo esc_html($stats_3_label); ?>
              </p>
            </div>

            <div class="flex flex-col items-center justify-center py-6">
              <h1 class="text-4xl md:text-5xl font-semibold">
                <?php echo esc_html($stats_4_number); ?>
              </h1>
              <p class="text-sm md:text-lg">
                <?php echo esc_html($stats_4_label); ?>
              </p>
            </div>
          </div>

          <?php if ($stats_logo_image) : ?>
            <img src="<?php echo esc_url($stats_logo_image); ?>"
              class="absolute right-0 top-1/2 -translate-y-1/2 w-24 md:w-32 lg:w-40 pointer-events-none select-none"
              alt="">
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- SECTION 4: SLIDE + LĨNH VỰC -->
<section>
  <div class="bg-[#F7F7F7] relative z-0 mt-46">
    <div class="container mx-auto p-4 py-10 font-hd relative">

      <div class="space-y-2 sm:ml-7 md:pr-8 pb-6 md:pb-0 max-w-[430px]">
        <div class="flex items-center gap-3">
          <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
          <h2 class="text-main font-medium text-2xl font-playfair">Lĩnh vực</h2>
        </div>

        <div class="text-[#0F3857] font-semibold text-2xl md:text-3xl leading-[130%] uppercase">
          <h1>Các lĩnh vực kinh doanh chính </h1>
        </div>

        <p class="line-clamp-3">
          Nhôm Kính Gia Phan chuyên tư vấn, thiết kế, sản xuất và thi công các giải pháp nhôm
          kính chất lượng cao.
        </p>
      </div>

      <div class="mt-6 sm:mt-8 lg:mt-0 lg:absolute lg:right-0 lg:top-1/3 lg:-translate-y-1/3 lg:z-20 lg:max-w-[60%]">
        <div class="swiper linhvuc-swiper">
          <div class="swiper-wrapper">

            <!-- cart 1 -->
            <div class="swiper-slide">
              <div class="p-4 cart bg-white rounded-xl shadow-md max-w-[358px] font-hd">
                <div>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-linh-vuc1.svg" class="w-full" alt="">
                </div>
                <h3 class="mt-4 font-bold leading-[130%] text-main text-5xl">01</h3>
                <div class="mt-2 flex gap-3">
                  <p class="leading-[130%] text-xl font-hd flex-1 line-clamp-3">
                    Thi công nhôm kính công nghiệp
                  </p>
                  <div
                    class="flex items-center justify-center w-10 h-10 border border-main rounded-full bg-white/80">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- cart 2 -->
            <div class="swiper-slide">
              <div class="p-4 cart bg-white rounded-xl shadow-md max-w-[358px] font-hd">
                <div>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-linh-vuc1.svg" class="w-full" alt="">
                </div>
                <h3 class="mt-4 font-bold leading-[130%] text-main text-5xl">02</h3>
                <div class="mt-2 flex gap-3">
                  <p class="leading-[130%] text-xl font-hd flex-1 line-clamp-3">
                    Thi công nhôm kính dân dụng
                  </p>
                  <div
                    class="flex items-center justify-center w-10 h-10 border border-main rounded-full bg-white/80">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- cart 3 -->
            <div class="swiper-slide">
              <div class="p-4 cart bg-white rounded-xl shadow-md max-w-[358px] font-hd">
                <div>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-linh-vuc1.svg" class="w-full" alt="">
                </div>
                <h3 class="mt-4 font-bold leading-[130%] text-main text-5xl">03</h3>
                <div class="mt-2 flex gap-3">
                  <p class="leading-[130%] text-xl font-hd flex-1 line-clamp-3">
                    Cửa nhôm, vách kính, mặt dựng
                  </p>
                  <div
                    class="flex items-center justify-center w-10 h-10 border border-main rounded-full bg-white/80">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- cart 4 -->
            <div class="swiper-slide">
              <div class="p-4 cart bg-white rounded-xl shadow-md max-w-[358px] font-hd">
                <div>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-linh-vuc1.svg" class="w-full" alt="">
                </div>
                <h3 class="mt-4 font-bold leading-[130%] text-main text-5xl">04</h3>
                <div class="mt-2 flex gap-3">
                  <p class="leading-[130%] text-xl font-hd flex-1 line-clamp-3">
                    Phụ kiện & giải pháp nhôm kính
                  </p>
                  <div
                    class="flex items-center justify-center w-10 h-10 border border-main rounded-full bg-white/80">
                    <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                      <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22" stroke-width="0.744"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="absolute left-[30%] -bottom-20 flex gap-3">
      <button class="linhvuc-prev cursor-pointer w-[46px] h-[46px] rounded-full text-main border">
        <i class="fa-solid fa-angle-left"></i>
      </button>
      <button class="linhvuc-next cursor-pointer w-[46px] h-[46px] rounded-full text-main border">
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>

  </div>
</section>

<!-- SECTION 5: DỰ ÁN  -->

<section class="mt-40 bg-[url('public/img/decor.svg')] bg-cover bg-center bg-no-repeat">
  <div class="container mx-auto px-4 py-10 font-hd">

    <div class="flex justify-center mb-8">
      <div class="space-y-4 text-center max-w-[500px]">
        <div class="flex items-center gap-3 justify-center">
          <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
          <h2 class="text-main font-medium text-2xl font-playfair">Dự án</h2>
        </div>
        <div class="text-[#0F3857] font-semibold text-2xl md:text-3xl leading-[130%] uppercase">
          <h1>Các DỰ ÁN NỔI BẬT TẠI GIA PHAN</h1>
        </div>
        <p class="line-clamp-2 font-hd text-base leading-[150%] font-normal">
          Nhôm Kính Gia Phan chuyên tư vấn, thiết kế, sản xuất và thi công các giải pháp nhôm
          kính chất lượng cao.
        </p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

      <div class="w-full">
        <div class="max-h-[330px] overflow-y-auto pr-2 scroll-red">

          <!-- item 1 (active) -->
          <div
            class="flex items-center justify-between py-3 pl-2 border-b-2 border-dashed border-gray-200 cursor-pointer">
            <div class="flex items-center gap-3">
              <h1 class="text-[#afafaf] font-extrabold leading-[130%] text-4xl">01</h1>
              <h1 class="text-main font-bold leading-[130%] text-2xl">
                Công ty Freewell khu 4.7ha
              </h1>
            </div>
            <div>
              <button class="cursor-pointer w-10 h-10 rounded-full text-main border flex items-center justify-center">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- item 2 -->
          <div
            class="group flex items-center justify-between py-3 pl-2 border-b-2 border-dashed border-gray-200 cursor-pointer">
            <div class="flex items-center gap-3">
              <h1
                class="text-[#00000028] group-hover:text-[#afafaf] transition-colors duration-200 font-extrabold leading-[130%] text-4xl">
                02
              </h1>
              <h1 class="text-main font-bold leading-[130%] text-2xl">
                Công ty Freewell khu 4.7ha
              </h1>
            </div>
            <div>
              <button
                class="cursor-pointer w-10 h-10 rounded-full text-main border opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- item 3 -->
          <div
            class="group flex items-center justify-between py-3 pl-2 border-b-2 border-dashed border-gray-200 cursor-pointer">
            <div class="flex items-center gap-3">
              <h1
                class="text-[#00000028] group-hover:text-[#afafaf] transition-colors duration-200 font-extrabold leading-[130%] text-4xl">
                03
              </h1>
              <h1 class="text-main font-bold leading-[130%] text-2xl">
                Công ty Freewell khu 4.7ha
              </h1>
            </div>
            <div>
              <button
                class="cursor-pointer w-10 h-10 rounded-full text-main border opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- item 4 -->
          <div
            class="group flex items-center justify-between py-3 pl-2 border-b-2 border-dashed border-gray-200 cursor-pointer">
            <div class="flex items-center gap-3">
              <h1
                class="text-[#00000028] group-hover:text-[#afafaf] transition-colors duration-200 font-extrabold leading-[130%] text-4xl">
                04
              </h1>
              <h1 class="text-main font-bold leading-[130%] text-2xl">
                Công ty Freewell khu 4.7ha
              </h1>
            </div>
            <div>
              <button
                class="cursor-pointer w-10 h-10 rounded-full text-main border opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- item 5 -->
          <div
            class="group flex items-center justify-between py-3 pl-2 border-b-2 border-dashed border-gray-200 cursor-pointer">
            <div class="flex items-center gap-3">
              <h1
                class="text-[#00000028] group-hover:text-[#afafaf] transition-colors duration-200 font-extrabold leading-[130%] text-4xl">
                05
              </h1>
              <h1 class="text-main font-bold leading-[130%] text-2xl">
                Công ty Freewell khu 4.7ha
              </h1>
            </div>
            <div>
              <button
                class="cursor-pointer w-10 h-10 rounded-full text-main border opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

        </div>

        <div class="flex justify-end mt-5">
          <button
            class="cursor-pointer inline-flex items-center justify-center px-5 py-3 border-[1.5px] border-main rounded-md font-semibold leading-5 hover:bg-main hover:text-white transition-colors">
            Xem tất cả dự án
          </button>
        </div>
      </div>

      <div class="w-full flex justify-center sm:justify-end">
        <div class="swiper duan-swiper w-full max-w-[360px] sm:max-w-[420px] lg:max-w-[520px]">
          <div class="swiper-wrapper">

            <!-- card 1 -->
            <div class="swiper-slide">
              <div class="rounded-xl overflow-hidden shadow-md">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/duan1.png" alt="Dự án 1" class="w-full h-auto object-cover">
              </div>
            </div>

            <!-- card 2 -->
            <div class="swiper-slide">
              <div class="rounded-xl overflow-hidden shadow-md">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/duan2.svg" alt="Dự án 2" class="w-full h-auto object-cover">
              </div>
            </div>

            <!-- card 3 -->
            <div class="swiper-slide">
              <div class="rounded-xl overflow-hidden shadow-md">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/duan1.png" alt="Dự án 3" class="w-full h-auto object-cover">
              </div>
            </div>

            <!-- card 4 -->
            <div class="swiper-slide">
              <div class="rounded-xl overflow-hidden shadow-md">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/duan2.svg" alt="Dự án 4" class="w-full h-auto object-cover">
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- SECTION 5: ĐỐI TÁC -->
<?php
$partners_label = get_theme_mod('partners_label', 'Đối tác - khách hàng');
$partners_title = get_theme_mod('partners_title', 'đồng hành cùng nhôm kính gia phan');

// Lấy danh sách logo từ Customizer
$partner_logos = [];
for ($i = 1; $i <= 8; $i++) {
  $logo = get_theme_mod("partners_logo_$i");
  if ($logo) {
    $partner_logos[] = $logo;
  }
}

if (empty($partner_logos)) {
  $default_logo = get_template_directory_uri() . '/assets/img/logo-doi-tac.svg';
  $partner_logos = array_fill(0, 16, $default_logo);
}
?>

<section>
  <div class="container mx-auto">
    <div class="p-4 py-10 font-hd flex justify-center">
      <div class="space-y-4 text-center max-w-[600px]">
        <div class="flex items-center gap-3">
          <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
          <h2 class="text-main font-medium text-2xl font-playfair">
            <?php echo esc_html($partners_label); ?>
          </h2>
        </div>
        <div class="text-[#0F3857] font-semibold text-2xl md:text-3xl leading-[130%] uppercase">
          <h1><?php echo esc_html($partners_title); ?></h1>
        </div>
      </div>
    </div>

    <div class="mx-35">
      <?php if (! empty($partner_logos)) : ?>
        <div class="flex flex-wrap justify-center gap-4">
          <?php foreach ($partner_logos as $logo) : ?>
            <div class="basis-[14.2857%] max-w-[14.2857%] flex justify-center">
              <img src="<?php echo esc_url($logo); ?>" alt="">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>


<!-- SECTION: TIN TỨC -->
<section>
  <div class="container mx-auto px-4 mt-30 space-y-4">
    <div class="font-hd flex justify-between items-center">
      <div>
        <div class="space-y-4 ">
          <div class="flex items-center gap-3">
            <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
            <h2 class="text-main font-medium text-2xl font-playfair "> Cập nhật liên tục</h2>
          </div>
          <div class="text-[#0F3857] font-semibold text-2xl md:text-3xl leading-[130%] uppercase">
            <h1>tin tức nổi bật</h1>
          </div>
        </div>
      </div>

      <div>
        <button
          class=" cursor-pointer float-left items-center justify-center px-5 py-3 border-[1.5px] border-main rounded-md font-semibold leading-5 hover:bg-main hover:text-white transition-colors">
          Xem Tất cả dự án
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

      <div class="lg:col-span-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Card lớn 1 -->
          <article class="bg-white rounded-lg font-hd">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tin-tuc2.svg" alt="" class="rounded-lg w-full  object-cover">
            <div class="p-5 space-y-2">
              <div class="text-xs text-gray-500 flex items-center gap-2">
                <span class="text-red-500 text-lg">•</span>
                <span>29/08/2025</span>
              </div>
              <h3 class="font-semibold text-lg leading-snug">
                Kinh nghiệm chọn kính cho phòng thay đồ hay nhất: Tối ưu không gian và ánh sáng
              </h3>
              <p class="text-sm text-gray-500 line-clamp-3">
                Khám phá các mẫu cửa nhôm kính mới nhất, dẫn đầu xu hướng thiết kế nội thất hiện đại cho ngôi nhà của
                bạn...
              </p>
            </div>
          </article>

          <!-- Card lớn 2 -->
          <article class="bg-white rounded-lg font-hd">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tin-tuc2.svg" alt="" class="rounded-lg w-full  object-cover">
            <div class="p-5 space-y-2">
              <div class="text-xs text-gray-500 flex items-center gap-2">
                <span class="text-red-500 text-lg">•</span>
                <span>29/08/2025</span>
              </div>
              <h3 class="font-semibold text-lg leading-snug line-clamp-3">
                Lợi ích khi sử dụng cửa nhôm kính cách âm cho nhà ở thành phố
              </h3>
              <p class="text-sm text-gray-500 line-clamp-3">
                Khám phá các mẫu cửa nhôm kính hiện đại, giúp giảm tiếng ồn và tăng tính thẩm mỹ cho không gian
                sống...
              </p>
            </div>
          </article>

        </div>
      </div>

      <div class="lg:col-span-4 flex flex-col gap-6">

        <!-- Card ngang 1 -->
        <article class="relative bg-white rounded-lg overflow-hidden shadow-sm font-hd">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tin-tuc1.svg" alt="" class="w-full  object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4 right-4">
            <h3 class="text-white font-semibold text-sm md:text-base leading-snug">
              Lan can kính cường lực: giải pháp an toàn và tinh tế cho ngôi nhà bạn
            </h3>
          </div>
        </article>

        <!-- Card ngang 2 -->
        <article class="relative bg-white rounded-lg overflow-hidden shadow-sm font-hd">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tin-tuc1.svg" alt="" class="w-full  object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4 right-4">
            <h3 class="text-white font-semibold text-sm md:text-base leading-snug">
              Bảng giá cửa nhôm Xingfa mới nhất: các yếu tố ảnh hưởng đến chi phí
            </h3>
          </div>
        </article>

      </div>
    </div>
  </div>
</section>


<?php get_footer(); ?>