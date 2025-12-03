<?php

/**
 * Template Name: Dịch vụ
 */; ?>

<?php get_header(); ?>
<main>
    <!-- SECTION 1: BANNER -->
    <section>
        <div class="">
            <img src="<?php get_template_directory_uri() . '/assets/img/banner-service.svg'; ?>" class="w-full  object-cover" alt="">
        </div>
    </section>

    <!-- SECTION 2: Breadcrumb -->
    <section>
        <nav class="text-center font-hd space-x-2 my-8">
            <a href="#" class="text-main-title font-semibold text-base">Trang Chủ /</a>
            <a href="#" class="text-[#5C5C5C]">Dich vụ</a>
        </nav>
    </section>

    <section>
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-3 justify-center">
                <div>
                    <div class="flex items-center gap-3 justify-start">
                        <div class="w-[73px] bg-main h-0.5 hidden sm:block"></div>
                        <h2 class="text-main font-playfair text-3xl">Dịch Vụ</h2>
                    </div>

                    <h2 class="text-main-title font-bold text-2xl md:text-3xl leading-[130%] uppercase">
                        Các dịch vụ nổi bật tại gia phan
                    </h2>
                </div>
            </div>

            <?php get_template_part('part/cart-service'); ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>