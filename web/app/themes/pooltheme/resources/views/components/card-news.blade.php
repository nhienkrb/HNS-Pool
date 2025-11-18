@props(['post' => null])
@if ($post)
    <div class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
        <img src="{{ get_the_post_thumbnail_url($post->ID, 'large') }}"
            class="w-full h-[305px] object-cover p-3 rounded-3xl" alt="   {!! $post->post_title ?? '' !!}" />

        <div class="p-2 space-y-3">
            <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                <span class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">
                    {{ get_the_category($post->ID)[0]->name ?? 'Tin tức' }}
                </span>
                <div class="w-1 h-1 bg-black rounded mx-2"></div>
                <span class="font-semibold text-base leading-4 text-black">{{ get_the_date('d.m.Y', $post->ID) }}</span>
            </div>

            <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                {!! $post->post_title ?? '' !!}
            </h3>
            <div class="flex justify-between">
                <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                    {!! wp_trim_words($post->post_excerpt, 20) ?? '' !!}
                </p>
                <a href="{{ get_permalink($post) }}" class="flex items-center">
                    <span class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
@endif
