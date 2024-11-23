<?php

namespace App\Http\Requests\Register;

use Hamcrest\Arrays\IsArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePolsusRequest extends FormRequest
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
        $rules = [
            'filepond'      => 'image|max:4096',
            'jenis_polsus' => 'required',
            'no_hp' => 'required',
            'memiliki_izin_senpi_amunisi' => 'required',
            'nama'            => 'required',
            'tempat_lahir'    => 'required',
            'tanggal_lahir'   => 'required',
            'pangkat'         => 'required',
            'golongan'        => 'required',
            'no_nip'          => 'required',
            'jabatan'         => 'required',
            'instansi_id'     => 'required',
            'detail_alamat'   => 'required',
            'provinsi'        => 'required',
            'kabupaten'       => 'required',
            'kecamatan'       => 'required',
            'desa'            => 'required',
            'rt'              => 'nullable|numeric',
            'rw'              => 'nullable|numeric',
            'jenjang_diklat'  => 'required',
            'kepemilikan_kta' => 'required',
            'kelengkapan_perorangan' => 'required|string',
            'ruang'           => 'string'
        ];

        if(request()->post('kepemilikan_kta') == '1') {
            $rules = array_merge($rules, [
                'no_skep' => 'required',
                'no_kta'  => 'required',
                'pejabat_yang_mengeluarkan_kta'     => 'required',
                'expired_kta'                       => 'required',
            ]);
        }

        if(request()->post('memiliki_izin_senpi_amunisi') == '1') {
            $rules = array_merge($rules, [
                'no_izin_pegang_senpi'      => 'required|string',
                'pejabat_yang_mengeluarkan_izin_pegang_senpi' => 'required|string',
                'expired_izin_pegang'       => 'required|date',
            ]);
        }

        if(request()->post('jenjang_diklat') != 'belum') {
            $rules = array_merge($rules, [
                'no_ijazah'          => 'required',
                'tempat_dikeluarkan_ijazah' => 'required',
                'tanggal_dikeluarkan_ijazah'=> 'required|date',
            ]);
        }

        $instansiIdHaveKategoriPolsus = ['2', '3', '7', '8'];
        if(in_array(request()->post('instansi_id'), $instansiIdHaveKategoriPolsus)) {
            $rules = array_merge($rules, [
                'kategori' => 'required',
            ]);
        }

        return $rules;
    }
}
