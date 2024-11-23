<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataOrsosmas;

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
        if($this->request->has('laporan')) {
            $this->redirect = route('data-orsosmas.index');
            return $this->importRules();
        }
        return $this->storeRules();
    }

    private function importRules()
    {
        return [
            'laporan'                   => 'required|array',
            'laporan.*.polda'           => 'required',
            'laporan.*.polres'          => 'required',
            'laporan.*.type'            => 'required',
            'laporan.*.nama_orsosmas'   => 'required',
            'laporan.*.dasar_hukum'     => 'nullable',
            'laporan.*.tanggal_dasar_hukum' => 'nullable',
            'laporan.*.akta_notaris'        => 'required',
            'laporan.*.tanggal_akta_notaris'=> 'required',
            'laporan.*.npwp'            => 'required',
            'laporan.*.provinsi'        => 'required',
            'laporan.*.kabupaten'       => 'required',
            'laporan.*.kecamatan'       => 'required',
            'laporan.*.desa'            => 'required',
            'laporan.*.jalan'           => 'required',
            'laporan.*.rt'              => 'nullable',
            'laporan.*.rw'              => 'nullable',
            'laporan.*.sumber_dana'     => 'required',
            'laporan.*.bidang_kegiatan' => 'required',
            'laporan.*.jml_anggota'     => 'required',
            'laporan.*.nama_ketua'      => 'required',
            'laporan.*.no_hp_ketua'     => 'required',
        ];
    }

    private function storeRules()
    {
        return [
            'data'                   => 'required|array',
            'data.*.polda'           => 'required',
            'data.*.polres'          => 'required',
            'data.*.type'            => 'required',
            'data.*.nama_orsosmas'   => 'required',
            'data.*.dasar_hukum'     => 'nullable',
            'data.*.tanggal_dasar_hukum' => 'nullable',
            'data.*.akta_notaris'        => 'required',
            'data.*.tanggal_akta_notaris'=> 'required',
            'data.*.npwp'            => 'required',
            'data.*.provinsi_code'   => 'required',
            'data.*.kabupaten_code'  => 'required',
            'data.*.kecamatan_code'  => 'nullable',
            'data.*.desa_code'       => 'nullable',
            'data.*.provinsi'        => 'required',
            'data.*.kabupaten'       => 'required',
            'data.*.kecamatan'       => 'nullable',
            'data.*.desa'            => 'nullable',
            'data.*.jalan'           => 'nullable',
            'data.*.rt'              => 'nullable',
            'data.*.rw'              => 'nullable',
            'data.*.sumber_dana'     => 'required',
            'data.*.bidang_kegiatan' => 'required',
            'data.*.jml_anggota'     => 'required',
            'data.*.nama_ketua'      => 'required',
            'data.*.no_hp_ketua'     => 'required',
        ];
    }
}
