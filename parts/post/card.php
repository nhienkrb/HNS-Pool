<?php

/**
 * Card post news
 * Gọi trong WP Loop (have_posts())
 */;
?>


<div
    class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
    <?php if (has_post_thumbnail()):; ?>
        <?php the_post_thumbnail('medium', ['class' => 'w-full h-[305px] object-cover p-3 rounded-3xl']); ?>
    <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
    <?php endif; ?>

    <div class="p-2 space-y-3">
        <div class="flex text-xs  justify-start items-center mb-2 gap-1">
            <?php
            $cat = get_the_category();
            $cat_name = $cat ? $cat[0]->name : 'Tin tức';
            ?>
            <span class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">
                <?php echo esc_html($cat_name); ?>
            </span>
            <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
            <span class="font-semibold text-base leading-4 text-black"> <?php echo get_the_date('d.m.Y'); ?></span>
        </div>
        <h3 class="text-lg font-semibold text-black leading-6 mt-1">
            <a href="<?php the_permalink(); ?>" class="no-underline">
                <?php echo  Helpers::trim(get_the_title(), 12, '...') ?>
            </a>
        </h3>
        <div class="flex justify-between">
            <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                <?php echo  Helpers::excerpt(12); ?>
            </p>
            <a href="<?php the_permalink(); ?>" class="flex items-center">
                <span
                    class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</div>