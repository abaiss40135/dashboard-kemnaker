<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputDataSenpiAmunisiPolsusRequest extends FormRequest
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
            'instansi_id' => 'required',
            'jenis_polsus' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'detail_alamat' => 'required',
            'amunisi_panjang' => 'required|numeric',
            'amunisi_genggam' => 'required|numeric',
            'senpi_panjang' => 'required|numeric',
            'senpi_genggam' => 'required|numeric',
        ];

        $kategori = '';
        if(request()->post('instansi_id') == '8') {
            $kategori = 'kategori_daops';
        } else if(request()->post('instansi_id') == '7') {
            $kategori = 'kategori_unit';
        } else if(request()->post('instansi_id') == '3') {
            $kategori = 'kategori_lapas';
        } else if(request()->post('instansi_id') == '2') {
            $kategori = 'kategori_balai';
        }

        if($kategori) {
            $rules = array_merge($rules, [
                $kategori => 'required'
            ]);
        }

        return $rules;
    }
}
