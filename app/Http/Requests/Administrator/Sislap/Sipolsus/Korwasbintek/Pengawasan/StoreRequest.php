<?php

namespace App\Http\Requests\Administrator\Sislap\Sipolsus\Korwasbintek\Pengawasan;

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
            'laporan.*.polda'           => ['required'],
            'laporan.*.polres'          => ['required'],
            'laporan.*.bentuk_kegiatan' => ['required'],
            'laporan.*.jml_kegiatan'    => ['nullable'],
            'laporan.*.jml_pelaksana'   => ['nullable'],
            'laporan.*.hasil'           => ['nullable'],
            'laporan.*.kendala'         => ['nullable'],
            'laporan.*.solusi'          => ['nullable'],
        ];
    }
}
