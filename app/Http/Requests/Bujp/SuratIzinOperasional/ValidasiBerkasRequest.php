<?php

namespace App\Http\Requests\Bujp\SuratIzinOperasional;

use Illuminate\Foundation\Http\FormRequest;

class ValidasiBerkasRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'validasi' => $this->valid,
            'keterangan' => $this->message
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:berkas_pendaftaran_sio,id',
            'validasi' => 'required',
            'keterangan' => 'required_if:valid,false'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
