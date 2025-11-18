@props([
    'href' => '#',
])
<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'no-underline! inline-block bg-[#0D4A9A] text-white font-bold py-3 px-8 rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]',
    ]) }}>
    {{ $slot }}
</a>
