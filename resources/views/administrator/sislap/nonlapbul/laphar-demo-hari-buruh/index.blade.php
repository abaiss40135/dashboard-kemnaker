@extends('templates.admin.main')
@section('mainComponent')
    <div class="wrapper">
        <div class="content-wrapper">
            @component('components.admin.content-header')
                @slot('title', 'Laporan Demo Hari Buruh')
            @endcomponent
            <section class="content">
                <div class="container-fluid row mx-0">
                    <iframe src="/filemanager" class="w-100"
                            style="height: 80vh; overflow: hidden; border: none;"></iframe>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        let route_prefix = route('laphar-demo-hari-buruh.index');

        (function () {
            $('#lfm').filemanager('file', {prefix: route_prefix});
        })();
    </script>
@endsection
