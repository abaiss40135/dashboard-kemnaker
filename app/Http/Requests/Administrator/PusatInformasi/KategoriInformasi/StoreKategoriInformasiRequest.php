<?php

namespace App\Http\Requests\Administrator\PusatInformasi\KategoriInformasi;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriInformasiRequest extends FormRequest
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
            'name'           => ['required', 'unique:kategori_informasi,name'],
            'description'    => ['required'],
            'query'          => ['required'],
            'icon_primary'   => ['required', 'file'],
            'icon_secondary' => ['required', 'file']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
