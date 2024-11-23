<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PetugasPolmas;

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
        $this->redirect = route('petugas-polmas-kawasan-wilayah.index');
        return [
            'laporan.*.polda' => 'required|string',
            'laporan.*.polres' => 'required|string',
            'laporan.*.jumlah_rw' => 'required|integer',
            'laporan.*.jumlah_petugas_wilayah' => 'required|integer',
            'laporan.*.jumlah_petugas_kawasan' => 'required|integer',
            'laporan.*.jumlah_sdh_pelatihan_polmas' => 'required|integer',
            'laporan.*.lampiran_file' => 'required|file',
        ];
    }

    public function messages()
    {
        return [
            'polda.required' => 'Data Polda wajib diisi!',
            'polres.required' => 'Data Polres wajib diisi!',
            'jumlah_rw.required' => 'Data Jumlah RW wajib diisi!',
            'jumlah_sdh_pelatihan_polmas.required' => 'Data Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan wajib diisi!',
            'jumlah_petugas_wilayah.required' => 'Data Jumlah Petugas Wilayah wajib diisi!',
            'jumlah_petugas_kawasan.required' => 'Data Jumlah Petugas Kawasan wajib diisi!',
            'lampiran_file.required' => 'Data Lampiran File wajib diisi!',
            'jumlah_rw.integer' => 'Data Jumlah RW harus berupa angka!',
            'jumlah_petugas_wilayah.integer' => 'Data Jumlah Petugas Wilayah harus berupa angka!',
            'jumlah_petugas_kawasan.integer' => 'Data Jumlah Petugas Kawasan harus berupa angka!',
            'jumlah_sdh_pelatihan_polmas.integer' => 'Data Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan harus berupa angka!',
        ];
    }
}
