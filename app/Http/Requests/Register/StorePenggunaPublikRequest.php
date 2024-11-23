<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaPublikRequest extends FormRequest
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
            'name'           => ['required', 'max:255'],
            'email'          => ['required', 'max:255', 'unique:users'],
            'password'       => ['required', 'min:8', 'confirmed'],
            'alamat'         => ['required'],
            'type'           => ['required'],
            'pekerjaan'      => ['required'],
            'lokasi_bekerja' => ['required'],
            'captcha'        => ['required',
                function ($attribute, $value, $fail) {
                    if ($value !== session()->get('captcha')) {
                        $fail('Kode angka tidak cocok.');
                    }
                }
            ],
        ];
    }
}
