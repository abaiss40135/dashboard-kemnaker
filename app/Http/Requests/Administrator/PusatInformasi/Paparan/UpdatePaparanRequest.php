<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Paparan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaparanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'edit_nama_paparan' => 'required',
            'edit_gambar' => 'mimes:ppt,pptx,pdf',
            'edit_thumbnail' => 'mimes:jpg,png,jpeg,webp',
            'edit_tags' => 'nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
