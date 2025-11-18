@extends('layouts.app')

@section('content')
    <x-breadcrumbs />

    <div class="container mx-auto px-4">

        <section>
            <div class="my-10">
                <h1 class="text-4xl font-medium leading-tight">
                    {{ get_the_title() }}
                </h1>
            </div>
            <hr class="text-gray-300">
        </section>

        <section>
            <div class="flex justify-start items-center mt-5 gap-2.5">
                <span class="text-white font-semibold text-sm px-8 py-1.5 bg-[#0D4A9A] rounded-md">
                    {{ get_the_category()[0]->name ?? '' }}
                </span>

                <div class="w-1 h-1 bg-black rounded-full"></div>

                <p class="font-semibold">
                    {{ get_the_date('d.m.Y') }}
                </p>

                <div class="w-1 h-1 bg-black rounded-full"></div>

                <p class="font-semibold">
                    {{ get_the_author() }}
                </p>
            </div>
        </section>

        <section>
            <div class="mt-10 space-y-6 prose max-w-none">

                @if (has_post_thumbnail())
                    <img class="w-full h-[777px] object-cover rounded-lg"
                        src="{{ get_the_post_thumbnail_url(null, 'full') }}" alt="{{ get_the_title() }}">
                @endif

                <div class="text-[#3A3A3A] leading-7">
                    {!! apply_filters('the_content', get_the_content()) !!}
                </div>

            </div>
        </section>

        <section class="mt-16">
        </section>

    </div>
@endsection
