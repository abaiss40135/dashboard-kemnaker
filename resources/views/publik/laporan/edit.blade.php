@extends('templates.core.main')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/bhabin/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bhabin/laporan/dds/dds-form.css') }}">
@endsection
@section('mainComponent')
    @include('components.navbar.navbar-publik')

    <main class="bg-white container p-4" style="margin-top: 6rem; margin-bottom: 1rem;" >
        <form action="{{ route('laporan-publik.update' , $data->id ) }}" method="post" class="p-0">
                @csrf
                @method('put')
                <h4 class="text-center mb-5 mt=2">
                    <b>Form Laporan Masyarakat</b>
                </h4>
                <div class="my-3">
                    <label for="tanggal" class="form-label">Tanggal: </label>
                    <input type="text" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ $data->tanggal }}" readonly id="tanggal">
                </div>
                <div class="form-group">
                    <label class="form-label">Bidang Informasi</label><br>
                    <div class="d-flex justify-content-between mb-3 mt-2" style="max-width: 800px">
                        <div>
                            <input type="radio" {{ (old('laporan_informasi.bidang') ?? $data->laporan_informasi->bidang) == 'politik' ? 'checked' : ''  }}
                            class="form-check-input" name="laporan_informasi[bidang]"
                                   value="politik" required>
                            <label for="politik" class="form-check-label">Politik</label>
                        </div>
                        <div>
                            <input type="radio" {{ (old('laporan_informasi.bidang') ?? $data->laporan_informasi->bidang) == 'ekonomi' ? 'checked' : ''  }}
                            class="form-check-input" name="laporan_informasi[bidang]"
                                   value="ekonomi" style="margin-left: 10px;">
                            <label for="ekonomi" class="form-check-label" style="margin-left: 10px;">Ekonomi</label>
                        </div>
                        <div>
                            <input type="radio" {{ (old('laporan_informasi.bidang') ?? $data->laporan_informasi->bidang) == 'sosbud' ? 'checked' : ''  }}
                            class="form-check-input" name="laporan_informasi[bidang]"
                                   value="sosbud" style="margin-left: 10px;">
                            <label for="sosbud" class="form-check-label" style="margin-left: 10px;">Budaya</label>
                        </div>
                        <div>
                            <input type="radio" {{ (old('laporan_informasi.bidang') ?? $data->laporan_informasi->bidang) == 'sosial' ? 'checked' : ''  }}
                            class="form-check-input" name="laporan_informasi[bidang]"
                                   value="sosial" style="margin-left: 10px;">
                            <label for="sosial" class="form-check-label" style="margin-left: 10px;">Sosial</label>
                        </div>
                        <div>
                            <input type="radio" {{ (old('laporan_informasi.bidang') ?? $data->laporan_informasi->bidang) == 'keamanan' ? 'checked' : ''  }}
                            class="form-check-input" name="laporan_informasi[bidang]"
                                   value="keamanan" style="margin-left: 10px;">
                            <label for="keamanan" class="form-check-label" style="margin-left: 10px;">Keamanan</label>
                            <div class="invalid-feedback">hi</div>
                        </div>
                    </div>
                </div>
               <div class="my-3">
                    <label for="uraian" class="form-label">Uraian Laporan Masyarakat: </label>
                    <textarea name="laporan_informasi[uraian]" required class="form-control @error('laporan_informasi.uraian') is-invalid @enderror" placeholder="masukkan laporan" id="uraian" cols="30" rows="10">{{ @old('laporan_informasi.uraian') ?? $data->laporan_informasi->uraian }}</textarea>
                    @error('laporan_informasi.uraian')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
               </div>

                <div class="button mt-4 d-flex justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-danger" onclick="redirectBack()">Batal</button>
                    <button style="background: #A0B8E0; color: #1E4588;">Simpan</button>
                </div>
            </form>

    </main>

@endsection

@section('customjs')
    <script>
        const redirectBack = () => {
            window.location = "{{ route('laporan-publik.index') }}"
        }
    </script>
@endsection
