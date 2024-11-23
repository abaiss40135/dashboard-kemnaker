<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\Satkamling;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'polda' => 'required',
            'satkamling_aktif'  => 'required|numeric',
            'satkamling_pasif'  => 'required|numeric',
            'satkamling_jumlah' => 'required|numeric',
            'revitalisasi_baru' => 'required|numeric',
            'revitalisasi_lama' => 'required|numeric',
            'revitalisasi_jumlah' => 'required|numeric',
        ];
    }
}
