<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\PenangananGempaCianjur;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge([
            'data' => Arr::where(json_decode($this->data, true), function ($value, $key) {
                return !empty($value['personel_id']) && !empty($value['district_code']) && !empty($value['jenis_kegiatan']);
            })
        ]);
    }

    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*.personel_id' => 'required|exists:personel,personel_id',
            'data.*.district_code' => 'required|exists:districts,code',
            'data.*.tanggal' => 'required|date_format:Y-m-d',
            'data.*.jenis_kegiatan_text' => 'required',
            'data.*.jenis_kegiatan' => 'required',
            'data.*.uraian_kegiatan' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
