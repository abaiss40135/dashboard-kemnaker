<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Meme;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_meme' => 'required',
            'caption'   => 'required',
            'gambar'    => 'required|mimes:jpeg,png,jpg,svg,webp',
            'tags'      => 'nullable|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
