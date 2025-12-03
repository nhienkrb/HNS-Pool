<?php

/**
 * Template Name: Dự án
 */; ?>

<?php get_header(); ?>

<main>
    <!-- SECTION 1: BANNER -->
    <?php
    $banner = get_theme_mod('service_banner_image', get_template_directory_uri() . '/assets/img/banner-service.svg');
    ?>

    <section>
        <div>
            <img src="<?php echo esc_url($banner); ?>" class="w-full object-cover" alt="Banner Dịch vụ">
        </div>
    </section>

    <!-- SECTION 2: Breadcrumb -->
    <section>
        <nav class="text-center font-hd space-x-2 my-8">
            <a href="#" class="text-main-title font-semibold text-base">Trang Chủ /</a>
            <a href="#" class="text-[#5C5C5C]">Dự án</a>
        </nav>
    </section>


    <!-- Giới thiệu -->
    <section>
        <div class="flex items-center gap-3 justify-center space-y-4">
            <div>
                <div class="flex items-center gap-3 justify-start">
                    <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
                    <h2 class="text-main font-playfair text-3xl">Cập nhật liên tục</h2>
                </div>

                <h2 class="text-main-title font-bold text-2xl md:text-3xl leading-[130%] uppercase">
                    dự án mới nhất
                </h2>
            </div>
        </div>
    </section>

    <?php  get_template_part('part/project/project-grid'); ?>

    <!-- SECTION 3: PAGINATION -->
    <section class="py-6">
        <div class="container px-4">
            <nav class="mt-2 sm:mt-6 flex justify-center">
                <!-- WRAPPER CHO MOBILE SCROLL NGANG -->
                <div class="max-w-full overflow-x-auto">
                    <ul class="flex items-center gap-1.5 sm:gap-3 font-hd text-xs sm:text-sm whitespace-nowrap">

                        <!-- Prev -->
                        <li>
                            <button class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full border border-main text-main
                     hover:bg-main hover:text-white transition">
                                <i class="fa-solid fa-angle-left text-[10px] sm:text-xs"></i>
                            </button>
                        </li>

                        <!-- Page 1 -->
                        <li>
                            <button class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center rounded
                     border border-gray-300 text-gray-700
                     hover:border-main hover:text-main transition">
                                1
                            </button>
                        </li>

                        <!-- Page 2 (active) -->
                        <li>
                            <button class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center rounded
                     border border-main bg-main text-white transition">
                                2
                            </button>
                        </li>

                        <!-- Page 3 -->
                        <li>
                            <button class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center rounded
                     border border-gray-300 text-gray-700
                     hover:border-main hover:text-main transition">
                                3
                            </button>
                        </li>

                        <!-- Page 4 -->
                        <li>
                            <button class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center rounded
                     border border-gray-300 text-gray-700
                     hover:border-main hover:text-main transition">
                                4
                            </button>
                        </li>

                        <!-- ... -->
                        <li class="hidden xs:flex sm:flex">
                            <span
                                class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center text-gray-400">
                                ...
                            </span>
                        </li>

                        <!-- Page 10 -->
                        <li class="hidden xs:flex sm:flex">
                            <button class="min-w-8 h-8 sm:min-w-9 sm:h-9 px-2 sm:px-3 flex items-center justify-center rounded
                     border border-gray-300 text-gray-700
                     hover:border-main hover:text-main transition">
                                10
                            </button>
                        </li>

                        <!-- Next -->
                        <li>
                            <button class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full border border-main text-main
                     hover:bg-main hover:text-white transition">
                                <i class="fa-solid fa-angle-right text-[10px] sm:text-xs"></i>
                            </button>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </section>

</main>


<?php get_footer(); ?>