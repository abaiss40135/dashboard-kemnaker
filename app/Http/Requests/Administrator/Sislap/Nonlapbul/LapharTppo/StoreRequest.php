<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharTppo;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('laphar-tppo.index');
        return [
            'laporan' => 'required|array',
            'laporan.*.polda'   => 'required',
            'laporan.*.polres'  => 'required',
            'laporan.*.tatap_muka'  => 'required|numeric',
            'laporan.*.media_cetak' => 'required|numeric',
            'laporan.*.media_sosial'  => 'required|numeric',
            'laporan.*.binluh'      => 'required|numeric',
            'laporan.*.koordinasi_p3mi' => 'required|numeric',
            'laporan.*.koordinasi_dinas' => 'required|numeric',
            'laporan.*.workshop'    => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
