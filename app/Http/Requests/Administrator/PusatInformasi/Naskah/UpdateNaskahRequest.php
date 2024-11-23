<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Naskah;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNaskahRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_naskah' => 'required',
            'file_naskah'   => 'nullable|mimes:ppt,pptx,pdf',
            'tags'      => 'nullable|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
