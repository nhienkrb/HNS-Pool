@props([
    'post' => null 
])

@if ($post)
    <a href="{{ get_permalink($post->ID) }}"
        class="col-span-1 border no-underline! bg-white border-gray-200 rounded-lg overflow-hidden shadow-md transition duration-300 hover:shadow-xl">
        
        <div class="bg-gray-100 rounded-lg m-1 p-3 h-64 flex justify-center items-center">

            @if (has_post_thumbnail($post->ID))
                {!! get_the_post_thumbnail($post->ID, 'medium', [
                    'class' => 'max-h-full w-auto object-contain',
                    'alt' => $post->post_title, 
                ]) !!}
            @else
                <img src="{{ asset('images/product1.png') }}" alt="{{ $post->post_title }}"
                     class="max-h-full w-auto object-contain">
            @endif
        </div>

        <div class="p-4 text-center">
            <p class="text-sm font-bold text-[#0D4A9A] uppercase">
                {{ $post->post_title }}
            </p>
        </div>

    </a>
@endif