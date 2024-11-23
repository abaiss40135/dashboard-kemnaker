<?php

namespace App\Http\Requests\Administrator\Jukrah;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJukrahRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'file'=> 'nullable|mimes:pdf,jpeg,png,jpg,svg,webp',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
