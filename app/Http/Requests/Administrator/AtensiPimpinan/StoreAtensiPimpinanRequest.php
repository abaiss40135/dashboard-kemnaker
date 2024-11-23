<?php

namespace App\Http\Requests\Administrator\AtensiPimpinan;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtensiPimpinanRequest extends FormRequest
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
            "sasaran"   => "required",
            "judul"     => "required",
            "isi"       => "required",
            "pemberi" => "required|exists:personel,personel_id",
        ];
    }

    public function messages()
    {
        return [
            'pemberi.exists' => 'Personel yang anda inputkan sudah tidak terdaftar dalam SIPP!'
        ];
    }
}
