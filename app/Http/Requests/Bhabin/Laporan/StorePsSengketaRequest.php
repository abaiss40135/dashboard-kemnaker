<?php

namespace App\Http\Requests\Bhabin\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class StorePsSengketaRequest extends FormRequest
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
            "tanggal" => "required",
            "waktu_kejadian" => "required",
            "nama_pihak_1",
            "pekerjaan_pihak_1",
            "alamat_pihak_1",
            "provinsi_pihak_1",
            "kabupaten_pihak_1",
            "kecamatan_pihak_1",
            "desa_pihak_1",
            "rt_pihak_1",
            "rw_pihak_1",
            "nama_pihak_2",
            "pekerjaan_pihak_2",
            "alamat_pihak_2",
            "provinsi_pihak_2",
            "kabupaten_pihak_2",
            "kecamatan_pihak_2",
            "desa_pihak_2",
            "rt_pihak_2",
            "rw_pihak_2",
            "uraian_kejadian" => "required|min:50",
            "saksi",
            "uraian_problem_solving" => "nullable|min:50",
            "surat_kesepakatan",
            "nama_narasumber" => "required",
            "pekerjaan_narasumber" => "required",
            "alamat_narasumber" => "required",
            "hari_masalah_selesai",
            "tanggal_masalah_selesai",
            "keyword" => ["required", "array"]
        ];
    }

    public function messages()
    {
        return [
            "uraian_kejadian.min" => "Uraian kejadian harus lebih dari 50 karakter, mohon lebih detail dan komprehensif",
            "uraian_problem_solving.min" => "Uraian problem solving harus lebih dari 50 karakter, mohon lebih detail dan komprehensif",
        ];
    }
}
