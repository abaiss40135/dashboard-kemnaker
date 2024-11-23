@extends('templates.admin.main')
@section('customcss')
<style>
    .inputLabel {
        background: #30589A;
        color: #fff;
        height: fit-content;
        width: fit-content;
        padding: 6px 20px;
        white-space: nowrap;
        margin-bottom: 0;
    }

    input[type='file'] {
        display: none;
    }
</style>
@endsection
@section('mainComponent')
<div class="wrapper">
    <div class="content-wrapper">
        @component('components.admin.content-header')
            @slot('title', 'Slider Gambar Landing')
        @endcomponent
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @if(count($data) < 7)
                        <button class="btn btn-primary my-4" data-toggle="modal" data-target="#tambah_gambar">
                            <i class="fas fa-plus mr-1"></i> Tambah Gambar
                        </button>
                        <div class="modal fade" id="tambah_gambar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Gambar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="form_tambah_gambar" action="{{ route('slider-picture.store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group input-group d-flex flex-column justify-content-between">
                                                <label for="" class="form-label">Gambar Berita</label>
                                                <div class="d-flex align-items-center" style="height: fit-content">
                                                    <input type="text" disabled class="form-control w-100"
                                                        name="file_placeholder"
                                                        placeholder="*.jpeg/jpg/png/webp" onchange="inputValue(this)">
                                                    <label for="gambar" class="inputLabel">Pilih File</label>
                                                    <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp"
                                                        onchange="inputValue(this)" name="gambar" id="gambar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger">terjadi kesalahan, tidak bisa mengupload gambar</div>
                            @endif
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="bg-primary text-center">
                                        <th style="width: 48%">Gambar</th>
                                        <th style="width: 18%">Judul</th>
                                        <th style="width: 22%">Diperbarui</th>
                                        <th style="width: 12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $gambar)
                                    <tr>
                                        <td>
                                            <div class="w-100" style="height: 30vh; overflow-y: scroll">
                                                <img src="{{ $gambar->url_file }}" class="w-100" loading="lazy">
                                            </div>
                                        </td>
                                        <td class="text-center">Slider {{ $key+1 }}</td>
                                        <td class="text-center">{{ $gambar->updated_at->translatedFormat(config('app.long_datetime_format')) }}</td>
                                        <td>
                                            <span class="d-flex justify-content-center">
                                                <button class="btn btn-warning" data-toggle="modal"
                                                        data-target="#edit_gambar_{{ $gambar->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <div class="modal fade" id="edit_gambar_{{ $gambar->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit gambar</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="form_edit_gambar_{{ $gambar->id }}"
                                                                action="{{ route('slider-picture.update', $gambar->id) }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <img src="{{ $gambar->url_file }}" class="w-100 mb-3" loading="lazy">
                                                                    <div class="form-group input-group d-flex flex-column justify-content-between">
                                                                        <label for="" class="form-label">File Gambar</label>
                                                                        <div class="d-flex align-items-center" style="height: fit-content">
                                                                            <input type="text" disabled class="form-control w-100" readonly
                                                                                   value="{{ $gambar->file }}" name="file_placeholder"
                                                                                   placeholder="*.png/jpg/jpeg/webp" onchange="inputValue(this)">
                                                                            <label for="gambar" class="inputLabel">Pilih File</label>
                                                                            <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="inputValue(this)"
                                                                                   name="edit[file]" id="gambar">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="{{ route('download') }}" method="get">
                                                <input type="hidden" name="url" value="{{ $gambar->file }}">
                                                    <button class="btn ml-2 btn-primary">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                </form>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark"></aside>
@endsection
