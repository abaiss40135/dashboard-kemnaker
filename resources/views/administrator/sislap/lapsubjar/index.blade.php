@php use App\Helpers\Constants; @endphp
@extends('templates.admin-lte.admin', ['title' => 'Laporan Subdit Jajaran'])
@section('content')
    <section class="row" style="row-gap: 1rem">
        @can('sipolsus_access')
            <div class="col-sm-6 col-md-4">
                <a href="{{route('sipolsus')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Sipolsus</b></h4>
                    </div>
                </a>
            </div>
        @endcan
        @can('binpolmas_access')
            <div class="col-sm-6 col-md-4">
                <a href="{{route('binpolmas')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Binpolmas</b></h4>
                    </div>
                </a>
            </div>
        @endcan
        @if (auth()->user()->haveRole(array_merge(Constants::OPERATOR_BAGOPSNALEV, ['administrator'])))
            <div class="col-sm-6 col-md-4">
                <a href="{{route('bhabin')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Bhabinkamtibmas</b></h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="{{ route('binkamsa')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Binkamsa</b></h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="{{ route('bintibsos') }}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Bintibsos</b></h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="{{ route('komsatpam')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Komsatpam Polsus</b></h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="{{ route('bagrenmin')}}" class="card h-100 d-flex align-items-center">
                    <div class="card-header text-center py-4">
                        <i class="fas fa-book-reader" style="font-size: 100px"></i>
                    </div>
                    <div class="card-body py-1 d-flex align-items-center">
                        <h4 class="text-center"><b>Bagrenmin</b></h4>
                    </div>
                </a>
            </div>
        @endif
    </section>
@endsection
