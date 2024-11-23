<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\DataFkpmWilayah;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $this->redirect = route('data-fkpm-wilayah.index');
        return [
            'laporan.*.polda'            => ['required'],
            'laporan.*.polres'           => ['required'],
            'laporan.*.nama_fkpm'        => ['required', 'min:0'],
            'laporan.*.nama_anggota_fkpm'=> ['required', 'min:0'],
            'laporan.*.model_wilayah'    => ['required', 'min:0'],
            'laporan.*.bkpm'    => ['required', 'min:0'],
            'laporan.*.rw'               => ['required', 'min:0'],
            'laporan.*.dusun'            => ['required', 'min:0'],
            'laporan.*.desa_kel'         => ['required', 'min:0'],
            'laporan.*.kecamatan'         => ['required', 'min:0'],
            'laporan.*.kab_kota'         => ['required', 'min:0'],
            'laporan.*.provinsi'         => ['required', 'min:0'],
            'laporan.*.keterangan'       => ['required', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
