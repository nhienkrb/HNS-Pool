<?php

/**
 * Template Name: Tin tức
 */; ?>
<?php get_header(); ?>
<main>
    <!-- SECTION 1: BANNER -->
    <section>
        <div>
            <?php
            $banner = get_theme_mod(
                'news_banner_image',
                get_theme_file_uri('/assets/img/banner-service.svg') // fallback nếu chưa chọn trong Customizer
            );
            ?>
            <img src="<?php echo esc_url($banner); ?>"
                class="w-full object-cover"
                alt="<?php esc_attr_e('Banner trang Tin tức', 'giaphan'); ?>">
        </div>
    </section>

    <!-- SECTION 2: Breadcrumb -->
    <section>
        <nav class="text-center font-hd space-x-2 my-8">
            <a href="#" class="text-main-title font-semibold text-base">Trang Chủ /</a>
            <a href="#" class="text-[#5C5C5C]">Tin tức</a>
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
                    Tin tức nổi bật
                </h2>
            </div>
        </div>
    </section>
    <!-- SECTION: TIN TỨC -->
    <section>
        <?php get_template_part('part/news/card-news'); ?>
    </section>

    <!--SECTION: TIN TỨC MỖI NGÀY  -->
    <section>
        <div class="flex items-center gap-3 justify-center mt-10">
            <div>
                <div class="flex items-center gap-3 justify-start">
                    <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
                    <h2 class="text-main font-playfair text-3xl">Dịch Vụ</h2>
                </div>

                <h2 class="text-main-title font-bold text-2xl md:text-3xl leading-[130%] uppercase">
                    tin tức cập nhật mỗi ngày
                </h2>
            </div>
        </div>
    </section>

    <?php
    $news = Queries::posts(6);
    ?>

    <?php if ($news->have_posts()) : ?>
        <section>
            <div class="max-w-7xl mx-auto px-4 mt-10">
                <div class="grid grid-cols-12 gap-4">
                    <?php while ($news->have_posts()) : $news->the_post(); ?>
                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                            <a href="<?php the_permalink(); ?>" class="block h-full">
                                <article class="bg-white rounded-lg font-hd h-full">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="rounded-lg w-full object-cover">
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/tin-tuc2-DDrApYYF.svg')); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="rounded-lg w-full object-cover">
                                    <?php endif; ?>

                                    <div class="space-y-1 mt-2">
                                        <div class="text-xs text-gray-500 flex items-center gap-2">
                                            <span class="text-main text-lg">•</span>
                                            <span><?php echo esc_html(get_the_date('d/m/Y')); ?></span>
                                        </div>
                                        <h3 class="font-semibold text-lg leading-snug line-clamp-2">
                                            <?php the_title(); ?>
                                        </h3>
                                    </div>
                                </article>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>



    <!-- SECTION : PAGINATION -->
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