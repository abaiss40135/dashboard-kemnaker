<?php

namespace App\Http\Requests\Administrator\Berita;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'judul'          => 'required',
            'pembuat_berita' => 'required',
            'isi_berita'     => 'required',
            'gambar'         => 'required|mimes:jpeg,png,jpg,svg,webp',
            'tags'           => 'nullable|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
