<?php

namespace App\Http\Requests\Keyword;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKeywordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keyword'   => ['nullable', 'string', 'unique:keywords,keyword'],
            'jumlah'    => ['nullable', 'numeric'],
            'tanggal'   => ['nullable', 'date'],
            'is_valid'  => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
