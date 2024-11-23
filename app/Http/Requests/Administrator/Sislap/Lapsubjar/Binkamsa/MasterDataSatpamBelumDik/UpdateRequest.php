<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik;

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
            'nama' => 'nullable',
            'perusahaan' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'lama_bertugas' => 'nullable',
            'dikum_terakhir' => 'nullable',
        ];
    }
}
