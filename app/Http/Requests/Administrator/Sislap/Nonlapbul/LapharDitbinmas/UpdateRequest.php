<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharDitbinmas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('laphar-ditbinmas.index');
        return [
            'polda'   => 'required',
            'satker'  => 'required',
            'binluh'  => 'required|numeric',
            'sambang' => 'required|numeric',
            'penmas'  => 'required|numeric',
            'ps'      => 'required|numeric',
            'pendampingan_dana_desa' => 'required|numeric',
            'pembuatan_li' => 'required|numeric',
            'keagamaan'    => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
