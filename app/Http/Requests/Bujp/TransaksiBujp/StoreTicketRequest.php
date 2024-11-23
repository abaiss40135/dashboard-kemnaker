<?php

namespace App\Http\Requests\Bujp\TransaksiBujp;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->haveRole(['bujp']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_izin'   => 'required|exists:data_checklist,id_izin',
            'handphone' => 'required|max:255',
            'kendala'   => 'required|max:255',
            'file'      => 'required|mimes:zip,rar,7z,jpg,jpeg,png'
        ];
    }
}
