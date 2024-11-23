<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class UpdateOpsDamaiCartenzRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('cartenz.index');

        return [
            'daops'      => 'required',
            'satgas'     => 'required',
            'jam'        => 'required',
            'kuat_pers'  => 'required',
            'lokasi'     => 'required',
            'kegiatan'   => 'required',
            'hasil'      => 'required',
            'keterangan' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
