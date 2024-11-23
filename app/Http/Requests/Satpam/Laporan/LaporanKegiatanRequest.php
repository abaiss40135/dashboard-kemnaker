<?php

namespace App\Http\Requests\Satpam\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class LaporanKegiatanRequest extends FormRequest
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
            'hari_kejadian' => 'required',
            'tanggal_kejadian' => 'required',
            'waktu_kejadian' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'nama_jalan' => 'required',
            'penyebab_kejadian' => 'required',
            'nama_pelaku' => 'required',
            'uraian_kejadian' => 'required',
            'jenis_kelamin_pelaku' => 'required',
            'alamat_pelaku' => 'required',
            'pekerjaan_pelaku' => 'required',
            'nomor_telepon_pelaku' => 'required',
            'nama_korban' => 'required',
            'jenis_kelamin_korban' => 'required',
            'alamat_korban' => 'required',
            'pekerjaan_korban' => 'required',
            'nomor_telepon_korban' => 'required',
            'hari_dilaporkan' => 'required',
            'tanggal_dilaporkan' => 'required',
            'waktu_dilaporkan' => 'required',
            'tindak_pidana' => ' required',
            'uraian_laporan' => 'required',
            'tindakan' => 'required'
        ];
    }
}
