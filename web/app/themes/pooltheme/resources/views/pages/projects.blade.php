{{-- 
    Template Name: Trang dự án nổi bật
 --}}
@extends('layouts.app')
@section('content')
    <x-breadcrumbs />
    @include('sections.projects.projects-session')
    <x-pagination />
@endsection
