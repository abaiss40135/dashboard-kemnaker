<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\Satkamling;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'laporan' => 'required|array',
            'laporan.*.polda' => 'required',
            'laporan.*.satkamling_aktif'  => 'required|numeric',
            'laporan.*.satkamling_pasif'  => 'required|numeric',
            'laporan.*.satkamling_jumlah' => 'required|numeric',
            'laporan.*.revitalisasi_baru' => 'required|numeric',
            'laporan.*.revitalisasi_lama' => 'required|numeric',
            'laporan.*.revitalisasi_jumlah' => 'required|numeric',
        ];
    }
}
