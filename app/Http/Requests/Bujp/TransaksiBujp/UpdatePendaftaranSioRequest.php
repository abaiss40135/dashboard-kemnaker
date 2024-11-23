<?php

namespace App\Http\Requests\Bujp\TransaksiBujp;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendaftaranSioRequest extends FormRequest
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
            'berkas_pendaftaran_sio' => 'nullable|array|min:1',
            'berkas_pendaftaran_sio.*' => 'nullable|mimes:pdf,xls,xlsx,doc,docx,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(){
        return [
            'berkas_pendaftaran_sio.*.mimes' => 'file harus berformat pdf,xls,xlsx,doc,docx,jpg,jpeg,png !',
            'berkas_pendaftaran_sio.*.max' => 'file harus berukuran maksimal 5MB',
        ];
    }
}
