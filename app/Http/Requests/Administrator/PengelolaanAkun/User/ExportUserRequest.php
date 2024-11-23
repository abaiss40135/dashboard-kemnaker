<?php

namespace App\Http\Requests\Administrator\PengelolaanAkun\User;

use Illuminate\Foundation\Http\FormRequest;

class ExportUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            "role.required" => "Kolom Hak Akses Wajib Diisi!"
        ];
    }
}
