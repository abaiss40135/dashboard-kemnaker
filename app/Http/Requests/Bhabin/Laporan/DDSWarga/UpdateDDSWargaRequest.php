<?php

namespace App\Http\Requests\Bhabin\Laporan\DDSWarga;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDDSWargaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nama_kepala_keluarga" => "required|min:3",
            "jenis_kelamin_kepala_keluarga" => "nullable",
            "tempat_lahir_kepala_keluarga" => "nullable",
            "tanggal_lahir_kepala_keluarga" => "nullable",
            "suku_kepala_keluarga" => "nullable",
            "agama_kepala_keluarga" => "nullable",
            "kewarganegaraan_kepala_keluarga" => "nullable",
            "no_tel_kepala_keluarga" => "nullable",
            "pekerjaan_kepala_keluarga" => "nullable",
            "provinsi_kepala_keluarga" => "nullable",
            "kabupaten_kepala_keluarga" => "nullable",
            "kecamatan_kepala_keluarga" => "nullable",
            "desa_kepala_keluarga" => "nullable",
            "detail_alamat_kepala_keluarga" => "nullable",
            "rt_kepala_keluarga" => "nullable",
            "rw_kepala_keluarga" => "nullable",
            "jumlah_anggota_keluarga_serumah" => "nullable",
            "anggota.*" => Rule::requiredIf(function (){
                return request('jumlah_anggota_keluarga_serumah') > 0;
            }),
            "nama_keluarga_bukan_serumah" => "nullable|min:3",
            "hubungan" => "nullable|min:3",
            "no_tel_keluarga_bukan_serumah" => "nullable",
            "provinsi_keluarga_bukan_serumah" => "nullable",
            "kabupaten_keluarga_bukan_serumah" => "nullable",
            "kecamatan_keluarga_bukan_serumah" => "nullable",
            "desa_keluarga_bukan_serumah" => "nullable",
            "detail_alamat_keluarga_bukan_serumah" => "nullable",
            "rt_keluarga_bukan_serumah" => "nullable",
            "rw_keluarga_bukan_serumah" => "nullable",
            "tanggal" => "required",
            "kunjungan_ke" => "nullable",
            "nama_penerima_kunjungan" => "required|min:3",
            "foto_kunjungan" => "nullable|file",
            "keterangan" => "nullable",
            "pendapat.*" => [Rule::requiredIf(collect(request('pendapat'))->pluck('jenis_pendapat')->filter()->count() == 0)],
            "pendapat.0.bidang_pendapat" => 'required_if:pendapat.0.jenis_pendapat,keluhan',
            "pendapat.0.uraian" => 'required_if:pendapat.0.jenis_pendapat,keluhan',
            "pendapat.0.keyword" => 'required_if:pendapat.0.jenis_pendapat,keluhan',
            "pendapat.1.bidang_pendapat" => 'required_if:pendapat.1.jenis_pendapat,keluhan',
            "pendapat.1.uraian" => 'required_if:pendapat.1.jenis_pendapat,keluhan',
            "pendapat.1.keyword" => 'required_if:pendapat.1.jenis_pendapat,keluhan',
            "laporan_informasi.*" => "required",
            "laporan_informasi.uraian" => "min:50",
            "laporan_informasi.keyword" => "required",
            "laporan_informasi.id" => "nullable",
        ];
    }

    public function messages()
    {
        return [
            "pendapat.0.uraian.min" => "Uraian pendapat keluhan minimal 50 karakter, mohon lebih detail dan komprehensif",
            "pendapat.1.uraian.min" => "Uraian pendapat harapan minimal 50 karakter, mohon lebih detail dan komprehensif",
            "laporan_informasi.uraian.required" => "Uraian laporan informasi wajib untuk diisikan",
            "laporan_informasi.uraian.min" => "Uraian laporan informasi minimal 50 karakter, mohon lebih detail dan komprehensif",
        ];
    }
}
