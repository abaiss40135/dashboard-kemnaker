<?php

namespace App\Http\Requests\PolisiRW;

use Illuminate\Foundation\Http\FormRequest;

class LokasiPenugasanStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'village_code' => ['required'],
            'dusun' => ['required'],
            'rw' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
