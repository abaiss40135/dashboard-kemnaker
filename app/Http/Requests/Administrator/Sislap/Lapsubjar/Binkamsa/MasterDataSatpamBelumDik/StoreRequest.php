<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik;

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
            'laporan.*.nama' => 'nullable',
            'laporan.*.perusahaan' => 'nullable',
            'laporan.*.tanggal_lahir' => 'nullable',
            'laporan.*.jenis_kelamin' => 'nullable',
            'laporan.*.lama_bertugas' => 'nullable',
            'laporan.*.dikum_terakhir' => 'nullable',
        ];
    }
}
