<?php
$size    = $args['size']    ?? 'large';
$post_id = $args['post_id'] ?? get_the_ID(); 

if (!$post_id) {
    return; 
}

$link  = get_permalink($post_id);

$title = get_the_title($post_id);
$img   = get_the_post_thumbnail_url($post_id, 'large');


$location = 'Đang cập nhật';


$terms = wp_get_post_terms($post_id, 'project_category');

if (!empty($terms) && !is_wp_error($terms)) {
    $names    = wp_list_pluck($terms, 'name');
    $location = implode(', ', $names);
}

if (!$img) {
    $img = get_template_directory_uri() . '/assets/img/duan2.svg';
}

$max_h = [
    'large'  => 'max-h-[470px]',
    'medium' => 'max-h-[255px]',
    'small'  => 'h-full',
];
?>
<a href="<?php echo esc_url($link); ?>">
    <div class="relative rounded-2xl overflow-hidden shadow-md cursor-pointer <?php echo $max_h[$size]; ?>">
        <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover">
        <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black/70 to-transparent"></div>
        <div class="absolute left-5 bottom-6 text-white space-y-1">
            <p class="text-lg font-semibold"><?php echo esc_html($title); ?></p>
            <p class="text-sm"><?php echo esc_html($location); ?></p>
        </div>

        <button class="absolute right-4 bottom-5 w-9 h-9 rounded-full border border-white/80
                flex items-center justify-center text-white bg-white/10 backdrop-blur-sm">
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
    </div>
</a>
