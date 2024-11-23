<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat;

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
        if ($this->request->has('laporan')) {
            $this->redirect = route('data-komunitas-masyarakat.index');
            return $this->importRules();
        }

        return $this->storeRules();
    }

    private function importRules()
    {
        return [
            'laporan'                   => 'nullable|array',
            'laporan.*.nama_kommas'     => 'required|not_in:0,-',
            'laporan.*.polda'           => 'required|starts_with:POLDA',
            'laporan.*.polres'          => 'required|starts_with:POLRES',
            'laporan.*.akta_notaris'    => 'nullable|not_in:0,-',
            'laporan.*.tanggal_akta_notaris' => 'nullable|not_in:0,-',
            'laporan.*.npwp'            => 'nullable|not_in:0,-',
            'laporan.*.sumber_dana'     => 'required|not_in:0,-',
            'laporan.*.bidang_kegiatan' => 'required|not_in:0,-',
            'laporan.*.jml_anggota'     => 'required|not_in:0,-',
            'laporan.*.nama_ketua'      => 'required|not_in:0,-',
            'laporan.*.no_hp_ketua'     => 'required|not_in:0,-',
            'laporan.*.alamat'           => 'nullable|not_in:0,-',
//            'laporan.*.provinsi'        => 'required|exists:provinsi,name',
            'laporan.*.provinsi'        => 'required',
//            'laporan.*.kota'            => 'required|exists:kota,name',
            'laporan.*.kota'            => 'required',
            'laporan.*.kecamatan'        => 'required',
            'laporan.*.desa'            => 'required',
        ];
    }

    private function storeRules()
    {
        return [
            'data'                   => 'nullable|array',
            'data.*.nama_kommas'     => 'required|not_in:0,-',
            'data.*.polda'           => 'required|starts_with:POLDA',
            'data.*.polres'          => 'required|starts_with:POLRES',
            'data.*.akta_notaris'    => 'nullable',
            'data.*.tanggal_akta_notaris' => 'nullable',
            'data.*.npwp'            => 'nullable|not_in:0,-',
            'data.*.sumber_dana'     => 'required|not_in:0,-',
            'data.*.bidang_kegiatan' => 'required|not_in:0,-',
            'data.*.jml_anggota'     => 'required|not_in:0,-',
            'data.*.nama_ketua'      => 'required|not_in:0,-',
            'data.*.no_hp_ketua'     => 'required|not_in:0,-',
            'data.*.alamat'           => 'nullable|not_in:0,-',
        ];
    }

    public function messages()
    {
        $type = 'data';
        if ($this->request->has('laporan')) {
            $type = 'laporan';
        }

        return [
            "{$type}.*.polda.starts_with" => "Kolom/Input Polda harus diawali dengan POLDA",
            "{$type}.*.polres.starts_with" => "Kolom/Input Polres harus diawali dengan POLRES atau POLRESTA",
            "{$type}.*.nama_kommas.not_in" => "Kolom/Input Nama Komunitas Masyarakat tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.akta_notaris.not_in" => "Kolom/Input Akta Notaris tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.tanggal_akta_notaris.not_in" => "Kolom/Input Tanggal Akta Notaris tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.npwp.not_in" => "Kolom/Input NPWP tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.sumber_dana.not_in" => "Kolom/Input Sumber Dana tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.bidang_kegiatan.not_in" => "Kolom/Input Bidang Kegiatan tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.jml_anggota.not_in" => "Kolom/Input Jumlah Anggota tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.nama_ketua.not_in" => "Kolom/Input Nama Ketua tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.no_hp_ketua.not_in" => "Kolom/Input No HP Ketua tidak boleh berisi 0 atau -, harus data asli!",
            "{$type}.*.alamat.not_in" => "Kolom/Input Alamat tidak boleh berisi 0 atau -, harus data asli!",
//            "{$type}.*.provinsi.exists" => "Ada salah satu Provinsi pada kumpulan data yang tidak ditemukan di sistem kami, pastikan hurufnya besar semua",
//            "{$type}.*.kota.exists" => "Ada salah satu Kota pada kumpulan data yang tidak ditemukan di sistem kami, pastikan hurufnya besar semua",
        ];
    }
}
