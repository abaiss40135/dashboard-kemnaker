<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpam;

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
            'laporan.*.no_reg' => 'nullable',
            'laporan.*.nik' => 'nullable',
            'laporan.*.nama' => 'nullable',
            'laporan.*.tanggal_lahir' => 'nullable',
            'laporan.*.alamat' => 'nullable',
            'laporan.*.tinggi_berat_badan' => 'nullable',
            'laporan.*.gol_darah' => 'nullable',
            'laporan.*.rumus_sidik_jari' => 'nullable',
            'laporan.*.handphone' => 'nullable',
            'laporan.*.email' => 'nullable',
            'laporan.*.dikum_terakhir' => 'nullable',
            'laporan.*.npwp' => 'nullable',
            'laporan.*.perusahaan' => 'nullable',
            'laporan.*.jabatan' => 'nullable',
            'laporan.*.alamat_kantor' => 'nullable',
            'laporan.*.nomor_kantor' => 'nullable',
            'laporan.*.email_perusahaan' => 'nullable',
            'laporan.*.dik_terakhir_satpam' => 'nullable',
            'laporan.*.tahun_lulus' => 'nullable',
            'laporan.*.is_ex_tni_polri' => 'nullable',
            'laporan.*.pangkat' => 'nullable',
        ];
    }
}
