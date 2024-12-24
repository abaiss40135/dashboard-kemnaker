@extends('templates.dashboard.base', ['title' => $title ?? ''])
@section('headUtils')
    @yield('customcss')
@endsection
@section('navUtils')
    @include('templates.dashboard.navbar-admin')
    @include('templates.dashboard.sidebar-admin')
@endSection
@section('content')
    @yield('content')
@endsection
@section('bodyUtils')
    @yield('customjs')
@endsection