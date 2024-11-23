<?php

namespace App\Http\Requests\Bujp\LaporanSemester;

use Illuminate\Foundation\Http\FormRequest;

class PelatihanKeamananRequest extends FormRequest
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
            'nama_bujp' => 'required|string',
            'no_sio' => 'required|string',
            'pengguna_jasa' => 'required|string',
            'alamat' => 'required|string',
            'pihak_yang_menyewakan_tempat' => 'nullable|string',
            'tempat_diklat' => 'nullable|string',
            'fasilitas' => 'required',
            'jenis_diklat' => 'nullable|string',
            'waktu_diklat_dari' => 'required',
            'waktu_diklat_sampai' => 'required',
            'jumlah_peserta' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_bujp.required' => 'Nama Bujp tidak boleh kosong',
            'nama_bujp.string' => 'Nama Bujp harus berupa string',
            'nama_bujp.exists' => 'Nama Bujp tidak ditemukan di sistem kami! Silahkan hubungi admin',
        ];
    }
}
