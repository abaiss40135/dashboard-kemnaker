<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas;

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
        $this->redirect = route('kegiatan-petugas-polmas.index');

        return [
            'data' => 'required|array',
            'data.*.polda' => 'required',
            'data.*.polres' => 'required',
            'data.*.sambang' => 'required|numeric',
            'data.*.pemecahan_masalah' => 'required|numeric',
            'data.*.laporan_informasi' => 'required|numeric',
            'data.*.penanganan_perkara_ringan' => 'required|numeric',
            'data.*.lampiran' => 'required|file|mimes:pdf,xlsx,xls',
        ];
    }
}
