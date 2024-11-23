<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBansosRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('bansos.index');
        return [
            'laporan.*.jenis_bansos'   => ['required'],
            'laporan.*.jml_target'     => ['required'],
            'laporan.*.jml_disalurkan' => ['required'],
            'laporan.*.polda'          => ['required',  Rule::notIn(['-'])],
            'laporan.*.polres'         => ['required',  Rule::notIn(['-'])],
            'laporan.*.dokumentasi.*'  => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}