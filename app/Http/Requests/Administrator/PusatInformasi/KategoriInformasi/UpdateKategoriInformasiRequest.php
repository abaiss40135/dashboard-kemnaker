<?php

namespace App\Http\Requests\Administrator\PusatInformasi\KategoriInformasi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriInformasiRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!$this->has('active')){
            $this->merge([
                'active' => false,
            ]);
        };
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'unique:kategori_informasi,name,' . $this->kategori_informasi->id],
            'description'    => ['required'],
            'query'          => ['required'],
            'active'         => ['required'],
            'icon_primary'   => ['nullable', 'file'],
            'icon_secondary' => ['nullable', 'file']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
