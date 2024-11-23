<?php

namespace App\Http\Requests\Bhabin\Laporan\DDSWarga\TempatUsaha;

use Illuminate\Foundation\Http\FormRequest;

class StoreDDSTempatUsahaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "nama_tempat_usaha" => ["required"],
            "jenis_usaha" => ["required"],
            "jam_kerja_awal" => ["required", "date_format:H:i"],
            "jam_kerja_akhir" => ["required", "date_format:H:i"],
            "alamat_tempat_usaha" => ["required"],
            "no_telp_tempat_usaha" => ["required"],
            "jumlah_karyawan" => ["required", "numeric"],
            "is_asrama" => ["required", "boolean"],
            "penanggung_jawab" => ["required", "array"],
            "cara_komunikasi_darurat" => ["required"],
            "karyawan" => ["required", "array"],
            "tanggal_kunjungan" => ["required"],
            "nama_penerima_kunjungan" => ["required"],
            "catatan" => ["required"],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
