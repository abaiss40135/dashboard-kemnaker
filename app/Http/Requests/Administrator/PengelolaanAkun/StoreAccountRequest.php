<?php

namespace App\Http\Requests\Administrator\PengelolaanAkun;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class StoreAccountRequest extends FormRequest
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
            'role_id'   => ['required', 'array'],
            'email'     => ['required', 'string', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'min:3', 'confirmed'],
            'nrp'       => ['nullable']
        ];
        if (array_reduce([2, 8, 1], function ($isBhabin, $role_id) {
            return $isBhabin || in_array($role_id, [
                    UserSeeder::BHABIN,
                    UserSeeder::OPERATOR_BHABINKAMTIBMAS_POLDA,
                    UserSeeder::OPERATOR_POLDA,
                    UserSeeder::BHABINKAMTIBMAS_PENSIUN]);
        })) {
            $rules['nrp'] = ['required', 'digits:8', 'unique:users,nrp'];
        }
        return $rules;
    }
}
