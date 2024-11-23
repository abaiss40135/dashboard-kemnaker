<?php

namespace App\Http\Requests\Bujp;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBujpRequest extends FormRequest
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
            "nama_badan_usaha" => "required|string",
            "detail_alamat" => "required|string",
            "bidang_usaha" => "required|string"
        ];
    }
}
