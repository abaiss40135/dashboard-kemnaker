<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharDitbinmas;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('laphar-ditbinmas.index');
        return [
            'laporan' => 'required|array',
            'laporan.*.polda'   => 'required',
            'laporan.*.satker'  => 'required',
            'laporan.*.binluh'  => 'required|numeric',
            'laporan.*.sambang' => 'required|numeric',
            'laporan.*.penmas'  => 'required|numeric',
            'laporan.*.ps'      => 'required|numeric',
            'laporan.*.pendampingan_dana_desa' => 'required|numeric',
            'laporan.*.pembuatan_li' => 'required|numeric',
            'laporan.*.keagamaan'    => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
