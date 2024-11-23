<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Regulasi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegulasiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'          => ['required', Rule::in(['undang-undang', 'internal-polri', 'eksternal-polri'])],
            'nama_uu'       => ['required'],
            'deskripsi_uu'  => ['required'],
            'file_uu'       => ['nullable', 'file', 'mimetypes:application/pdf'],
            'tags'          => ['nullable', 'array']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
