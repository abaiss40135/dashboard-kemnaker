@extends('templates.admin.main')
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
                @slot('title', 'Video Tutorial Pelaporan')
                @endcomponent
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div style="position: relative; width: 100%; height: 80vh;">
                                <video style="position: absolute; inset: 0; object-position: center; width: 100%; height: 100%"
                                        controls preload="auto">
                                    <source src="{{ asset('video/video_sislap.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="p-3" style="background-color: rgba(50, 50, 50, 0.16)">
                            <div class="d-flex justify-content-end align-items-end">
                                <form action="{{ route('download-asset') }}" method="GET">
                                    <input type="hidden" name="url" value="video/video_sislap.mp4" />
                                    <input type="hidden" name="filename" value="video-sislap.mp4" />
                                    <button type="submit" class="btn btn-primary">Unduh</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
