<?php

namespace App\Http\Requests\Administrator\Jukrah;

use Illuminate\Foundation\Http\FormRequest;

class StoreJukrahRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'file' => 'required|mimes:pdf,jpeg,png,jpg,svg,webp',
            'type' => 'nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

