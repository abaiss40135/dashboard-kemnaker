<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul\PreemtifPmk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('preemtif-pmk.index');
        return [
            'polda'            => ['required'],
            'polres'           => ['required'],
            'sosialisasi'      => ['numeric', 'min:0'],
            'pengobatan'       => ['numeric', 'min:0'],
            'dekontaminasi'    => ['numeric', 'min:0'],
            'amplifikasi_meme' => ['numeric', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
