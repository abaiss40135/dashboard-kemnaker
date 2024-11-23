<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Meme;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_meme' => 'required',
            'caption'   => 'required',
            'gambar'    => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'tags'      => 'nullable|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
