@extends('templates.admin-lte.base', ['title' => $title ?? ''])
@section('headUtils')
    @yield('customcss')
@endsection
@section('navUtils')
    @include('templates.admin-lte.navbar-admin')
    @include('templates.admin-lte.sidebar-admin')
@endSection
@section('content')
    @yield('content')
@endsection
@section('bodyUtils')
    @yield('customjs')
@endsection