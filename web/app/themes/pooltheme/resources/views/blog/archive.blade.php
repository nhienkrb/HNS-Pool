{{--
  Template Name: Trang Tin tức
--}}

@extends('layouts.app')

@section('content')
    <x-breadcrumbs />
    <div class="container mx-auto px-4">
        @include('sections.news.recommend-news')
        @include('sections.news.list-news')
        <x-pagination />
    </div>
@endsection
