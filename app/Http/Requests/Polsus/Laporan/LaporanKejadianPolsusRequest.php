<?php

namespace App\Http\Requests\Polsus\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class LaporanKejadianPolsusRequest extends FormRequest
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
            'nama_kejadian' => 'required',
            'waktu_kejadian' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'nama_jalan' => 'required',
            'nama_korban' => 'required',
            "pelaku.*.idpelaku" => "",
            'pelaku.*.nama_pelaku' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'pelaku.*.alamat_pelaku' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'pelaku.*.pekerjaan_pelaku' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'pelaku.*.usia_pelaku' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            "saksi.*.idsaksi" => "",
            'saksi.*.nama_saksi' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'saksi.*.pekerjaan_saksi' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'saksi.*.alamat_saksi' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'barang_bukti' => strtolower(request()->getMethod()) == "patch" ? "" : "required",
            'uraian_kejadian' => 'required',
            'rencana_penanganan_kejadian' => 'required'
        ];
    }
}
