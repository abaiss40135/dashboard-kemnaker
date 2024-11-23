<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Naskah;

use Illuminate\Foundation\Http\FormRequest;

class StoreNaskahRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_naskah'       => ['required'],
            'file_naskah'       => ['required', 'file', 'mimetypes:application/pdf'],
            'tags'              => ['nullable', 'array']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
