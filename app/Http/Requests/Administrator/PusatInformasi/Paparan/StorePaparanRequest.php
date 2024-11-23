<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Paparan;

use Illuminate\Foundation\Http\FormRequest;

class StorePaparanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_paparan' => 'required',
            'gambar' => 'required|mimes:ppt,pptx,pdf',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,webp',
            'tags'  => 'nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
