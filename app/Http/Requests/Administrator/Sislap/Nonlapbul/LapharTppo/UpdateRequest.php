<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharTppo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('laphar-tppo.index');
        return [
            'polda' => 'required',
            'polres' => 'required',
            'tatap_muka' => 'required|numeric',
            'media_cetak' => 'required|numeric',
            'media_sosial' => 'required|numeric',
            'binluh' => 'required|numeric',
            'koordinasi_p3mi' => 'required|numeric',
            'koordinasi_dinas' => 'required|numeric',
            'workshop' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
