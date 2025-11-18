{{--
  Template Name: Trang Chủ Home
--}}
@extends('layouts.app')
@section('content')
    @include('sections.home.about')
    @include('sections.home.featured-product')
    @include('sections.home.featured-projects')
    @include('sections.home.featured-news')
@endsection
