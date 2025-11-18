<?php
/*
  Template Name: Sản phẩm hồ bơi
*/
?>
@extends('layouts.app')
@section('content')
    @php
        $product_query =
            isset($products) && $products instanceof \WP_Query
                ? $products
                : new \WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'paged' => max(1, get_query_var('paged')),
                ]);
        $products = $product_query->posts ?? [];
    @endphp
    <x-breadcrumbs />
    <div class="container mx-auto px-4">
        @include('sections.pool.banner')
        @include('sections.pool.products')
        <x-pagination :query="$product_query" />
    </div>
@endsection
