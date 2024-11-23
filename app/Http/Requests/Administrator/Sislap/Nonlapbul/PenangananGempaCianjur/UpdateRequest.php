<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\PenangananGempaCianjur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "tanggal" => ['required', 'date_format:Y-m-d'],
            "personel_id" => ['required', 'exists:personel,personel_id'],
            "lokasi" => ['required', 'string'],
            "district_code" => ['required', 'exists:districts,code'],
            "jenis_kegiatan" => ['required'],
            "jenis_kegiatan_text" => ['required'],
            "uraian_kegiatan" => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            "personel_id.required" => "Petugas harus diisi",
            "district_code.required" => "Lokasi harus diisi",
        ];
    }
}
