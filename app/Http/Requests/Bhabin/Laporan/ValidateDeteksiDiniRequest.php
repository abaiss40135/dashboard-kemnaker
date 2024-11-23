<?php

namespace App\Http\Requests\Bhabin\Laporan;

use App\Models\Deteksi_dini;
use Illuminate\Foundation\Http\FormRequest;

class ValidateDeteksiDiniRequest extends FormRequest
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
            "nama_narasumber" => "nullable",
            "pekerjaan" => "nullable",
            "detail_alamat" => "nullable",
            "rt" => "required",
            "rw" => "required",
            "desa" => "nullable",
            "kecamatan" => "nullable",
            "kabupaten" => "nullable",
            "provinsi" => "nullable",
            "tanggal" => "required",
            "jam_mendapatkan_informasi" => "nullable",
            "lokasi_mendapatkan_informasi" => "nullable",
            "metode_mendapatkan_informasi" => "nullable",
            "titik_mendapatkan_informasi" => "nullable", // temporary
            "laporan_informasi.*" => "required",
            "laporan_informasi.uraian" => [
                "required",
                "min:50",
                function ($attribute, $value, $fail) { 
                    if (Deteksi_dini::where('user_id', auth()->user()->id)
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->whereHas('laporan_informasi', fn ($q) => $q->where('uraian', 'ilike', $value))
                        ->exists()) $fail('Uraian informasi sama persis dengan uraian informasi anda sebelumnya.');
                }
            ],
            "urgensi" => "nullable",
            "keseringan" => "nullable",
        ];
    }

    public function messages()
    {
        return [
            "laporan_informasi.uraian.min" => "Uraian harus lebih dari 50 karakter, mohon lebih detail dan komprehensif",
        ];
    }
}
