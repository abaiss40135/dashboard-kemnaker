<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class StoreSatpamRequest extends FormRequest
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
            'nama'               => 'required',
            'no_ktp'             => 'required|numeric',
            'no_kta'             => 'required',
            'no_reg'             => 'required',
            'jenis_kelamin'      => 'required',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required',
            'detail_alamat'      => 'required',
            'provinsi'           => 'required',
            'kabupaten'          => 'required',
            'kecamatan'          => 'required',
            'desa'               => 'required',
            'rt'                 => 'required|numeric',
            'rw'                 => 'required|numeric',
            'tempat_lahir'       => 'required',
            'bujp_id'            => "required_if:$this->input('jenis_satpam'),outsourching",
            'tanggal_lahir'      => 'required',
            'agama'              => 'required',
            'no_hp'              => 'required|numeric',
            'tempat_tugas'       => 'required',
            'tanggal_terbit_kta' => 'nullable',
            'masa_berlaku_kta'   => 'required',
            'jenjang_pelatihan'  => 'required',
            'foto_kta'           => 'required|mimes:png,jpg',
            'captcha'            => ['required',
                function ($attribute, $value, $fail) {
                    if ($value !== session()->get('captcha')) {
                        $fail('Kode angka tidak cocok.');
                    }
                }
            ],
        ];
    }
}
