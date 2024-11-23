<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\PreemtifPmk;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('preemtif-pmk.index');
        return [
            'laporan.*.polda'            => ['required'],
            'laporan.*.polres'           => ['required'],
            'laporan.*.sosialisasi'      => ['numeric', 'min:0'],
            'laporan.*.pengobatan'       => ['numeric', 'min:0'],
            'laporan.*.dekontaminasi'    => ['numeric', 'min:0'],
            'laporan.*.amplifikasi_meme' => ['numeric', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
