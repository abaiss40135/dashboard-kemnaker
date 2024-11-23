<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Infografis;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfografisRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'judul'     => 'required',
            'deskripsi' => 'required',
            'gambar'    => 'nullable|mimes:jpeg,png,jpg',
            'tags'      => 'nullable|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
