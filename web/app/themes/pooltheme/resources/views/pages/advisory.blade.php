{{--
  Template Name: Trang Góc tư vấn
--}}

@extends('layouts.app')

@section('content')
    <x-breadcrumbs />
    <div class="container mx-auto px-4">
        @include('sections.advisory.advisory')
        @include('sections.advisory.advisory-news')
        <x-pagination />
    </div>
@endsection
