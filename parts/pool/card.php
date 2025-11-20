<?php

/**
 * Card sản phẩm
 * Gọi trong WP Loop (have_posts())
 * 
 */
?>

<div class="bg-white border border-[#8D8D8D] rounded-2xl p-2 flex flex-col items-center hover:shadow-lg transition">

    <!-- Ảnh -->
    <div class="w-full h-[322px] flex justify-center items-center bg-[#F4F4F4] rounded-2xl overflow-hidden">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium', ['class' => 'object-cover ']); ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product1.png"
                class="object-cover " alt="no-image">
        <?php endif; ?>
    </div>

    <!-- Title -->
    <h3 class="mt-3 text-sm text-center font-bold leading-[27px] uppercase text-[#0D4A9A]">
        <?php the_title(); ?>
    </h3>
</div>