@extends('templates.admin-lte.base', ['title' => $title])
@section('headUtils')
    @yield('customcss')
@endsection
@section('navUtils')
    @include('templates.admin-lte.navbar-bujp')
    @include('templates.admin-lte.sidebar-bujp')
@endSection
@section('content')
    @yield('content')
@endsection
@section('bodyUtils')
    @yield('customjs')
@endsection