<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBUJPRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'email'        => strtolower($this->email),
            'password'     => bcrypt($this->password),
            'bidang_usaha' => implode(',', $this->bidang_usaha)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_badan_usaha'               => 'required',
            'nib'                            => 'required|unique:bujps,nib',
            'tipe_badan_usaha'               => 'required',
            'detail_alamat'                  => 'required',
            'provinsi'                       => 'required',
            'kabupaten'                      => 'required',
            'kecamatan'                      => 'required',
            'desa'                           => 'required',
            'kode_pos'                       => 'required|numeric',
            'nomor_telepon'                  => 'required',
            'npwp_badan_usaha'               => 'required',
            'website_badan_usaha'            => 'required',
            'email'                          => 'required',
            'password'                       => 'required',
            'logo_badan_usaha'               => 'required|mimes:jpg,png',
            'bidang_usaha'                   => 'required',
            'nama_penanggung_jawab'          => 'required',
            'jabatan_penanggung_jawab'       => 'required',
            'nomor_telepon_penanggung_jawab' => 'required',
            'nomor_ktp_penanggung_jawab'     => 'required',
            'foto_penanggung_jawab'          => 'required|mimes:jpg,png',
            'foto_ktp_penanggung_jawab'      => 'required|mimes:jpg,png',
            'captcha'                        => ['required',
                function ($attribute, $value, $fail) {
                    if ($value !== session()->get('captcha')) {
                        $fail('Kode angka tidak cocok.');
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            "nib.unique" => 'BUJP Anda sudah terdaftar di BOS. Jika Anda lupa password, gunakan fitur "lupa password" di halaman login',
        ];
    }
}
