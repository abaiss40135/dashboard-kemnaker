<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePreemtifBbmRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('preemtif-bbm.index');
        return [
            'laporan.*.jenis_giat_preemtif'   => ['required'],
            'laporan.*.jml_masyarakat_dilibatkan'     => ['required'],
            'laporan.*.polda'          => ['required',  Rule::notIn(['-'])],
            'laporan.*.polres'         => ['required',  Rule::notIn(['-'])],
            'laporan.*.dokumentasi.*'  => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
