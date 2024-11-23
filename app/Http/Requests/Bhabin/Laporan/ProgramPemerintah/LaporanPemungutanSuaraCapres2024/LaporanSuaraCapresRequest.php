<?php

namespace App\Http\Requests\Bhabin\Laporan\ProgramPemerintah\LaporanPemungutanSuaraCapres2024;

use Illuminate\Foundation\Http\FormRequest;

class LaporanSuaraCapresRequest extends FormRequest
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
            'provinsi_kode' => 'required|exists:provinces,name',
            'kabupaten_kode' => 'required|exists:cities,name',
            'kecamatan_kode' => 'required|exists:districts,name',
            'kelurahan_kode' => 'required',
            'uraian_hasil_suara' => 'required',
            'suara_capres_1' => 'required|integer|min:0',
            'suara_capres_2' => 'required|integer|min:0',
            'suara_capres_3' => 'required|integer|min:0',
            'suara_tidak_sah' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'provinsi_kode.required' => 'Provinsi harus diisi',
            'provinsi_kode.exists' => 'Provinsi tidak ditemukan',
            'kabupaten_kode.required' => 'Kabupaten harus diisi',
            'kabupaten_kode.exists' => 'Kabupaten tidak ditemukan',
            'kecamatan_kode.required' => 'Kecamatan harus diisi',
            'kecamatan_kode.exists' => 'Kecamatan tidak ditemukan',
            'kelurahan_kode.required' => 'Kelurahan harus diisi',
            'uraian_hasil_suara.required' => 'Uraian hasil suara harus diisi',
            'suara_capres_1.required' => 'Suara capres 1 harus diisi',
            'suara_capres_1.integer' => 'Suara capres 1 harus berupa angka',
            'suara_capres_1.min' => 'Suara capres 1 tidak boleh kurang dari 0',
            'suara_capres_2.required' => 'Suara capres 2 harus diisi',
            'suara_capres_2.integer' => 'Suara capres 2 harus berupa angka',
            'suara_capres_2.min' => 'Suara capres 2 tidak boleh kurang dari 0',
            'suara_capres_3.required' => 'Suara capres 3 harus diisi',
            'suara_capres_3.integer' => 'Suara capres 3 harus berupa angka',
            'suara_capres_3.min' => 'Suara capres 3 tidak boleh kurang dari 0',
            'suara_tidak_sah.required' => 'Suara tidak sah harus diisi',
            'suara_tidak_sah.integer' => 'Suara tidak sah harus berupa angka',
            'suara_tidak_sah.min' => 'Suara tidak sah tidak boleh kurang dari 0',
        ];
    }
}
