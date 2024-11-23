<?php

namespace App\Http\Requests\Bujp\SuratIzinOperasional;

use Illuminate\Foundation\Http\FormRequest;

class PenjadwalanAuditRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'status_audit' => 0,
            'jadwal_audit' => $this->date . ' ' . $this->hour,
        ]);
    }

    public function rules(): array
    {
        return [
            'status_audit' => 'required',
            'jadwal_audit' => 'required|date_format:Y-m-d H:i'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
