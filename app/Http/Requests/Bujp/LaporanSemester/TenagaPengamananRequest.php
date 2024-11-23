<?php

namespace App\Http\Requests\Bujp\LaporanSemester;

use Illuminate\Foundation\Http\FormRequest;

class TenagaPengamananRequest extends FormRequest
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
            'nama_bujp' => 'required|string|max:200',
            'no_sio' => 'required|string|max:200',
            'tanggal_sio' => 'required|date',
            'pengguna_jasa' => 'required|string|max:200',
            'kualifikasi_gp' => 'nullable|integer',
            'kualifikasi_gm' => 'nullable|integer',
            'kualifikasi_gu' => 'nullable|integer',
            'perumahan' => 'nullable|integer',
            'hotel' => 'nullable|integer',
            'rumah_sakit' => 'nullable|integer',
            'perbankan' => 'nullable|integer',
            'pabrik' => 'nullable|integer',
            'toko' => 'nullable|integer',
            'perkebunan' => 'nullable|integer',
            'tambang' => 'nullable|integer',
            'kantor' => 'nullable|integer',
            'transportasi' => 'nullable|integer',
            'pendidikan' => 'nullable|integer',
        ];
    }
}
