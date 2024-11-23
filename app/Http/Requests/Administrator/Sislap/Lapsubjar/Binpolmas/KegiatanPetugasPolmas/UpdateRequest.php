<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas;

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
            'polda' => 'required',
            'polres' => 'required',
            'sambang' => 'required|numeric',
            'pemecahan_masalah' => 'required|numeric',
            'laporan_informasi' => 'required|numeric',
            'penanganan_perkara_ringan' => 'required|numeric',
            'lampiran' => 'nullable|file|mimes:pdf,xlsx,xls',
        ];
    }
}
