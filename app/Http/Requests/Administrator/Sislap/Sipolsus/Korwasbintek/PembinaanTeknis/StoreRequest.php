<?php

namespace App\Http\Requests\Administrator\Sislap\Sipolsus\Korwasbintek\PembinaanTeknis;

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
            'laporan.*.jml_kegiatan'    => ['required'],
            'laporan.*.jml_peserta'     => ['required'],
            'laporan.*.tempat_kegiatan' => ['required'],
            'laporan.*.hasil'           => ['required'],
            'laporan.*.kendala'         => ['required'],
            'laporan.*.solusi'          => ['required'],
        ];
    }
}