{{-- Paginate WP_Query với Tailwind classes --}}
@props(['query' => null])

@php
    $query = $query instanceof \WP_Query ? $query : ($GLOBALS['wp_query'] ?? null);
@endphp

@if ($query instanceof \WP_Query && $query->max_num_pages > 1)
    @php
        $links = paginate_links([
            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'    => '?paged=%#%',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $query->max_num_pages,
            'type'      => 'array',
            'prev_text' => '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
</svg>',
            'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>',
        ]);

        $classes = [
            'base'      => '!no-underline w-10 h-10 flex items-center justify-center text-sm font-medium rounded-full transition duration-200',
            'current'   => 'bg-[#0D4A9A] text-white font-bold',
            'dots'      => 'text-gray-500 font-medium',
            'prev_next' => 'w-10 h-10 flex items-center justify-center rounded-full border border-[#0D4A9A] text-[#0D4A9A] transition duration-200 hover:bg-[#0D4A9A] hover:text-white',
            'default'   => 'w-10 h-10 flex items-center justify-center rounded-full border border-[#0D4A9A] text-[#0D4A9A] transition duration-200 hover:bg-[#0D4A9A] hover:text-white',
        ];
    @endphp

    <section>
        <nav class="flex justify-center items-center space-x-2 my-13" aria-label="Pagination">
            @foreach ($links as $link)
                @php
                    $link = str_replace(
                        ['page-numbers', 'current', 'dots', 'prev', 'next'],
                        [$classes['base'], $classes['current'], $classes['dots'], $classes['prev_next'], $classes['prev_next']],
                        $link
                    );

                    if (!str_contains($link, $classes['current']) && !str_contains($link, $classes['prev_next']) && !str_contains($link, $classes['dots'])) {
                        $link = str_replace($classes['base'], $classes['base'] . ' ' . $classes['default'], $link);
                    }
                @endphp

                {!! $link !!}
            @endforeach
        </nav>
    </section>
@endif