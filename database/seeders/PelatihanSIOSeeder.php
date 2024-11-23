<?php

namespace Database\Seeders;

use App\Http\Controllers\API\OSS\OSSController;
use App\Models\BerkasPendaftaranSio;
use App\Models\OSS\Checklist;
use App\Models\Provinsi;
use App\Models\RiwayatSio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PelatihanSIOSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            abort(403, 'This seeder forbidden for production environment.');
        }

        DB::statement("truncate table riwayat_sio restart identity cascade;");

        $all_polda  = Provinsi::query()->pluck('code', 'polda');
        $file       = json_decode(file_get_contents(public_path('payload-receive-nib-adipati-karya-prima.json')), true);
        $this->command->getOutput()->progressStart(34);
        $latest_id_izin = null;
        $all_id_izin    = [];
        foreach ($all_polda as $polda => $code) {
            $id_izin = "I-" . date('YmdHis') . "{$code}" . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $replaced = array_replace_recursive($file["dataNIB"], [
                'id_izin' => $id_izin,
                'kd_daerah' => "{$code}00000000",
                'data_checklist' => [
                    [
                        'id_izin' => $id_izin,
                        'kd_daerah' => "{$code}00000000",
                    ]
                ]
            ]);
            Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'token' => sha1(config('oss-api.username') . config('oss-api.password') . $file["dataNIB"]["nib"] . date('Ymd'))
                ])->post(route('oss.receive-nib'), [
                    "dataNIB" => $replaced,
                ]);

            $riwayat_sio= RiwayatSio::query()->where('id_izin', $id_izin)->first();
            $array_berkas = [
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-ktp_pemohon.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-ktp_pemohon.jpg",
                    "jenis_berkas" => "ktp_pemohon",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-keanggotaan_asosiasi.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-keanggotaan_asosiasi.jpg",
                    "jenis_berkas" => "keanggotaan_asosiasi",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-bukti_setoran_pnpb.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-bukti_setoran_pnpb.jpg",
                    "jenis_berkas" => "bukti_setoran_pnpb",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-sertifikat_gada_utama_milik_ceo.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-sertifikat_gada_utama_milik_ceo.jpg",
                    "jenis_berkas" => "sertifikat_gada_utama_milik_ceo",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-konfirmasi_status_wajib_pajak.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-konfirmasi_status_wajib_pajak.jpg",
                    "jenis_berkas" => "konfirmasi_status_wajib_pajak",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-surat_permohonan.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-surat_permohonan.jpg",
                    "jenis_berkas" => "surat_permohonan",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-struktur_organisasi.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-struktur_organisasi.jpg",
                    "jenis_berkas" => "struktur_organisasi",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-cv.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-cv.jpg",
                    "jenis_berkas" => "cv",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-surat_pernyataan_bermaterai_non_asing.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-surat_pernyataan_bermaterai_non_asing.jpg",
                    "jenis_berkas" => "surat_pernyataan_bermaterai_non_asing",
                ],
                [
                    "riwayat_sio_id" => $riwayat_sio->id,
                    "nama" => "kansai-test-surat_pernyataan_bermaterai_berseragam.jpg",
                    "file" => "bujp/KANSAI TEST/sio/Minggu, 01 Agustus 2021/kansai-test-surat_pernyataan_bermaterai_berseragam.jpg",
                    "jenis_berkas" => "surat_pernyataan_bermaterai_berseragam",
                ],
            ];
            DB::table('berkas_pendaftaran_sio')->insert($array_berkas);
            if ($riwayat_sio->statusSios()->doesntExist()){
                $respReceiveLicense = (new OSSController())->receiveLicenseStatus($riwayat_sio->checklist->id_izin, 'Dokumen Diterima oleh Polda');
                if ($respReceiveLicense->isServerError()){
                    // TODO Server error OSS
                }
                $riwayat_sio->statusSios()->attach([1 => ['keterangan' => 'Berkas diteruskan ke ' . $polda . ' untuk proses verifikasi']]);
            }
            sleep(12);
            $this->command->getOutput()->progressAdvance();

            $all_id_izin[]  = $id_izin;
            $latest_id_izin = $id_izin;
        }
        //TODO: Duplicate data checklist for all pengajuan above
        $checklist = (array)DB::table('data_checklist')->where('id_izin', $latest_id_izin)->first();
        foreach ($all_id_izin as $id_izin){
            Checklist::updateOrCreate(['id_izin' => $id_izin], Arr::except($checklist, ['id', 'id_izin']));
        }
        $this->command->getOutput()->progressFinish();
    }
}
