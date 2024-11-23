<?php

namespace App\Http\Requests\Satpam\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class LaporanInformasiRequest extends FormRequest
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
            'nama_narasumber' => 'required',
            'pekerjaan' => 'required',
            'detail_alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'tanggal_mendapatkan_informasi' => 'required',
            'jam_mendapatkan_informasi' => 'required',
            'lokasi_mendapatkan_informasi' => 'required',
            'metode_mendapatkan_informasi' => 'required',
            'bidang_informasi' => 'required',
            'keyword' => 'required',
            'uraian_informasi' => 'required',
            'urgensi' => 'required',
            'keseringan' => 'required',
        ];
    }
}
