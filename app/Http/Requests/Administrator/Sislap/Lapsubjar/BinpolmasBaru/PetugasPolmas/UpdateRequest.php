<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PetugasPolmas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'polda' => 'required|string',
            'polres' => 'required|string',
            'jumlah_rw' => 'required|integer',
            'jumlah_petugas_wilayah' => 'required|integer',
            'jumlah_petugas_kawasan' => 'required|integer',
            'jumlah_sdh_pelatihan_polmas' => 'required|integer',
            'lampiran_file' => 'file',
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
            'jumlah_rw.integer' => 'Data Jumlah RW harus berupa angka!',
            'jumlah_petugas_wilayah.integer' => 'Data Jumlah Petugas Wilayah harus berupa angka!',
            'jumlah_petugas_kawasan.integer' => 'Data Jumlah Petugas Kawasan harus berupa angka!',
            'jumlah_sdh_pelatihan_polmas.integer' => 'Data Jumlah Petugas Polmas Yang Sudah Mengikuti Pelatihan harus berupa angka!',
            'lampiran_file.file' => 'Data Lampiran File harus berupa file!',
            'lampiran_file.mimes' => 'Data Lampiran File harus berupa file dengan format: docx, pdf!',
        ];
    }
}
