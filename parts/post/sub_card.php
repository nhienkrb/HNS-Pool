<?php

/**
 * sub_Card post news
 * Gọi trong WP Loop (have_posts())
 */;
?>
<div class="flex items-center space-x-4 pb-4 border-b border-gray-200 last:border-b-0">

    <div class="flex-shrink-0 w-24 h-24">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium', [
                'class' => 'w-full h-full object-cover rounded-lg',
                'alt'   => get_the_title(),
            ]); ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-2.png"
                alt="Default Image"
                class="w-full h-full object-cover rounded-lg">
        <?php endif; ?>
    </div>

    <div class="grow">
        <p class="text-sm font-medium leading-5 text-[#1E1E1E] mb-1">
            <?= get_the_date('d.m.Y'); ?>
        </p>

        <h3 class="text-base font-medium text-[#142345] hover:text-[#0D4A9A] transition duration-200 leading-tight mb-2">
            <?= esc_html(Helpers::trim(get_the_title(), 20)); ?>
        </h3>

        <a href="<?php the_permalink(); ?>"
            class="flex items-center text-[#0D4A9A] text-sm font-medium underline">
            <span class="w-7 h-7 border rounded-full mx-1 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </span>
            Xem chi tiết
        </a>
    </div>

</div>