<?php

namespace App\Http\Requests\Bhabin\Laporan\ProblemSolving;

use Illuminate\Foundation\Http\FormRequest;

class ValidateNonSengketaRequest extends FormRequest
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
            "tanggal_kejadian" => "required",
            "waktu_kejadian" => "required",
            "lokasi_kejadian" => "required",
            "uraian_masalah" => "required|min:50",
            "keyword" => "required",
            "nama_narasumber" => "required",
            "pekerjaan_narasumber" => "required",
            "alamat_narasumber" => "required",
           
        ];
    }

    public function messages()
    {
        return [
            "uraian_masalah.min" => "Uraian harus lebih dari 50 karakter, mohon lebih detail dan komprehensif",
        ];
    }
}
