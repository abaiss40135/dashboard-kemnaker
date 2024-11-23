<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\DataFkpmWilayah;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'data' => json_decode($this->data, true)
        ]);
    }

    public function rules(): array
    {
        if($this->request->has("laporan")) {
            $this->redirect = route('data-fkpm-wilayah.index');
            return $this->importRule();
        }

        return $this->storeRule();
    }

    private function importRule()
    {
        return [
            'laporan.*.polda'            => ['required'],
            'laporan.*.polres'           => ['required'],
            'laporan.*.nama_fkpm'        => ['required', 'min:0'],
            'laporan.*.nama_petugas_polmas'=> ['required', 'min:0'],
            'laporan.*.pangkat_petugas_polmas'=> ['required', 'min:0'],
            'laporan.*.no_hp_petugas_polmas'=> ['required', 'min:0'],
            'laporan.*.jumlah_anggota_fkpm'=> ['required', 'min:0'],
            'laporan.*.wilayah'    => ['required', 'min:0'],
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

    public function storeRule()
    {
        return [
            "data" => "required|array",
            'data.*.polda'            => ['required'],
            'data.*.polres'           => ['required'],
            'data.*.nama_fkpm'        => ['required', 'min:0'],
            'data.*.nama_petugas_polmas'=> ['required', 'min:0'],
            'data.*.pangkat_petugas_polmas'=> ['required', 'min:0'],
            'data.*.no_hp_petugas_polmas'=> ['required', 'min:0'],
            'data.*.jumlah_anggota_fkpm'=> ['required', 'min:0'],
            'data.*.wilayah'    => ['required', 'min:0'],
            'data.*.bkpm'    => ['required', 'min:0'],
            'data.*.rw'               => ['required', 'min:0'],
            'data.*.dusun'            => ['required', 'min:0'],
            'data.*.desa_kel'         => ['required', 'min:0'],
            'data.*.kecamatan'         => ['required', 'min:0'],
            'data.*.kab_kota'         => ['required', 'min:0'],
            'data.*.provinsi'         => ['required', 'min:0'],
            'data.*.keterangan'       => ['required', 'min:0'],
        ];
    }
}
