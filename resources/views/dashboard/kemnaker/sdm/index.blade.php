@extends('templates.dashboard.admin')

@section('content')
    @include('dashboard.kemnaker.sdm.partials.recap-links')
    @include('dashboard.kemnaker.sdm.partials.filters')
    @include('dashboard.kemnaker.sdm.partials.recaps')
    @include('dashboard.kemnaker.sdm.partials.tingkat-kehadiran')
    @include('dashboard.kemnaker.sdm.partials.profile-pegawai')
    @include('dashboard.kemnaker.sdm.partials.belum-naik-golongan')
    @include('dashboard.kemnaker.sdm.partials.permasalahan-kepangkatan')
@endsection
