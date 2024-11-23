<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class StoreOpsDamaiCartenzRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('cartenz.index');

        return [
            'laporan.*.daops'      => 'required',
            'laporan.*.satgas'     => 'required',
            'laporan.*.jam'        => 'required',
            'laporan.*.kuat_pers'  => 'required',
            'laporan.*.lokasi'     => 'required',
            'laporan.*.kegiatan'   => 'required',
            'laporan.*.hasil'      => 'required',
            'laporan.*.keterangan' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
