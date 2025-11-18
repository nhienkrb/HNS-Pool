{{--
  Template Name: Trang Giới thiệu
--}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">

        @include('sections.about.formation-development')
        @include('sections.about.our-journey')
        @include('sections.about.why-choose-us')
        @include('sections.about.our-products')

    </div>
@endsection
