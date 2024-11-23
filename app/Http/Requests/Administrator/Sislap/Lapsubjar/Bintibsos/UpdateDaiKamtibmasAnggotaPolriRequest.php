<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Bintibsos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDaiKamtibmasAnggotaPolriRequest extends FormRequest
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
            'polda'            => ['required'],
            'polres'           => ['required'],
            'nama'       => ["required"],
            'gender' => ["required"],
            'pangkat' => ['required'],
            'nrp' => ['required', 'numeric'],
            'jabatan' => ['required'],
            'kesatuan' => ['required'],
            'perorangan_kelompok' => ["required"],
            'no_suket_pelatihan' => ["required"],
            "tanggal_suket" => ["required", 'date'],
            "no_skep_pengangkatan" => ["required"],
            "tanggal_skep" => ["required", 'date'],
            "no_kta" => ["required", 'numeric'],
            "tanggal_kta" => ["required", 'date'],
            "no_hp" => ["required", "numeric"],
            "alamat" => ["required"],
            "provinsi" => ["required"],
            "kabupaten" => ["required"],
            "kecamatan" => ["required"],
            "kelurahan" => ["required"],
            "dusun" => [],
            "rw" => [],
            "rt" => [],
        ];
    }
}
