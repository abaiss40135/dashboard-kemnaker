<?php

namespace App\Http\Requests\Administrator\Sislap\Sipolsus\Korwasbintek\Pengawasan;

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
            'polda'           => ['required'],
            'polres'          => ['required'],
            'bentuk_kegiatan' => ['required'],
            'jml_kegiatan'    => ['required'],
            'jml_pelaksana'   => ['required'],
            'hasil'           => ['required'],
            'kendala'         => ['required'],
            'solusi'          => ['required'],
        ];
    }
}
