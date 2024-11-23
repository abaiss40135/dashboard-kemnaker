<?php


namespace App\Services;


use App\Actions\GenerateLampiranSioAction;
use App\Exceptions\ResponseOSSException;
use App\Helpers\CollectionHelper;
use App\Http\Controllers\API\OSS\OSSController;
use App\Http\Traits\FileUploadTrait;
use App\Mail\InvalidBerkasSioMail;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\OSS\NIB;
use App\Models\Provinsi;
use App\Models\RiwayatSio;
use App\Models\StatusSio;
use App\Repositories\Abstracts\BerkasPendaftaranSioRepositoryAbstract;
use App\Repositories\Abstracts\RiwayatSioRepositoryAbstract;
use Carbon\Carbon;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SIOService
{
    use FileUploadTrait;

    /**
     * @var RiwayatSioRepositoryAbstract
     */
    private $riwayatSIORepository;
    /**
     * @var BerkasPendaftaranSioRepositoryAbstract
     */
    private $berkasPendaftaranSioRepository;
    /**
     * @var StatusSioService
     */
    private $statusSioService;

    public function __construct(RiwayatSioRepositoryAbstract           $riwayatSioRepositoryAbstract,
                                BerkasPendaftaranSioRepositoryAbstract $berkasPendaftaranSioRepositoryAbstract,
                                StatusSioService                       $statusSioService)
    {
        $this->riwayatSIORepository = $riwayatSioRepositoryAbstract;
        $this->berkasPendaftaranSioRepository = $berkasPendaftaranSioRepositoryAbstract;
        $this->statusSioService = $statusSioService;
    }

    public function validasiBerkas($data, $berkas_id)
    {
        $this->berkasPendaftaranSioRepository->update($data, $berkas_id);
    }

    public function updateStatusSio($riwayatSioID, int $status, string $keterangan = '')
    {
        $riwayatSio = $this->riwayatSIORepository->find($riwayatSioID);
        return $riwayatSio->statusSios()->attach([$status => ['keterangan' => $keterangan, 'user_id' => auth()->user()->id, 'role' => auth()->user()->role()]]);
    }

    public function show($id)
    {
        $riwayatSio = RiwayatSio::with(['checklist.nib', 'dokumens.jenisBerkas'])->find($id);
        if (is_null($riwayatSio)){
            abort(404);
        }

        return [
            'data'              => $riwayatSio,
            'logs'              => $riwayatSio->log_statuses()->latest()->take(10)->get(),
            'status'            => StatusSio::orderBy('id')->pluck('status', 'id'),
            'verifikator'       => auth()->user()->roles()->first(['id'])->id,
            'status_terakhir'   => $riwayatSio->statusSios()->first()->id ?? null
        ];
    }

    public function update(array $data, $id)
    {
        $sio = $this->riwayatSIORepository->find($id, ['id', 'id_izin'])->load('checklist.nib:id,nama_perseroan,email_perusahaan,email_user_proses');

        if ($sio->checklist && $sio->checklist->nib) {
            $email_perusahaan = ($sio->checklist->nib->email_perusahaan !== '-')
                                ? $sio->checklist->nib->email_perusahaan
                                : $sio->checklist->nib->email_user_proses;
            $nama_perseroan   = $sio->checklist->nib->nama_perseroan;

            $this->uploadPath = 'bujp';
            $this->folderName = $nama_perseroan . '/sio/' . $sio->id_izin .'/' .Carbon::now()->translatedFormat(config('app.long_date_format')) . '/';
            if (Arr::has($data, 'hasil_audit')) {
                $sio->status_audit = $data['hasil_audit'];
                $sio->penilaian_audit = $data['hasil_audit'] == 2 ? $data['penilaian_audit'] : null;
            }
            if (Arr::has($data, 'file_hasil_audit')) {
                $fileAudit = $data['file_hasil_audit'];
                $this->fileName = $sio->id . '-' . Str::slug($nama_perseroan) . '-file_hasil_audit.' . $fileAudit->getClientOriginalExtension();

                $sio->file_hasil_audit = $this->saveFiles($fileAudit);
            }
            if (Arr::has($data, 'file_surat_rekomendasi')) {
                $fileRekom = $data['file_surat_rekomendasi'];
                $this->fileName = $sio->id . '-' . Str::slug($nama_perseroan) . '-file_surat_rekomendasi.' . $fileRekom->getClientOriginalExtension();

                $sio->file_surat_rekom = $this->saveFiles($fileRekom);
            }

            if (!$sio->validasi_hasil_audit && role('operator_polda')){
                $sio->validasi_hasil_audit = null;
            }

            if (!$sio->validasi_surat_rekom && role('operator_polda')){
                $sio->validasi_surat_rekom = null;
            }

            if (Arr::has($data, 'validasi_hasil_audit')) {
                $sio->validasi_hasil_audit = $data['validasi_hasil_audit'];;
                $sio->keterangan_validasi_hasil_audit = !$data['validasi_hasil_audit'] ? $data['keterangan_validasi_hasil_audit'] : null;
            }
            if (Arr::has($data, 'validasi_surat_rekom')) {
                $sio->validasi_surat_rekom = $data['validasi_surat_rekom'];
                $sio->keterangan_validasi_surat_rekom = !$data['validasi_surat_rekom'] ? $data['keterangan_validasi_surat_rekom'] : null;
            }
            $sio->save();
            $this->updateStatusByRoleAndDocuments($sio, $email_perusahaan);
        }
    }

    /**
     * @throws HttpClientException
     */
    private function updateStatusByRoleAndDocuments($sio, $email_perusahaan)
    {
        $sio             = RiwayatSio::find($sio->id);
        $isOperatorPolda = role('operator_polda');
        $isOperatorMabes = roles(['operator_mabes', 'operator_mabes_2']);
        $OSSAPI          = new OSSController();

        if ($sio->dokumens()->invalid()->count() > 0) {
            /**
             * Ada dokumen yang tidak valid
             */
            if ($isOperatorPolda) {
                $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_POLDA, 'Dokumen dinyatakan tidak valid oleh ' . $sio->polda);
            }
            if ($isOperatorMabes) {
                $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_MABES, 'Dokumen persyaratan BUJP dinyatakan tidak valid oleh Operator Mabes');
                sleep(1);
                $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_POLDA, 'Dokumen persyaratan dikembalikan ke Operator '. $sio->polda .' untuk diperbaiki dan diverifikasi ulang.');
            }
            Mail::to($email_perusahaan)
                ->cc(config('mail.cc_email'))
                ->send(new InvalidBerkasSioMail($sio));
        } else {
            /**
             * semua dokumen valid
             */
            if ($isOperatorPolda) {
                $messageLicense = '';
                if ($sio->status_audit == 2) {
                    $messageLicense = 'Tidak lulus audit';
                    $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_POLDA, $messageLicense);
                }
                if ($sio->status_audit == 1 && !empty($sio->file_hasil_audit) && !empty($sio->file_surat_rekom)) {
                    // Lolos Audit
                    $messageLicense = 'Dokumen Lolos Verifikasi ' . $sio->polda;
                    $this->updateStatusSio($sio->id, $this->statusSioService::LOLOS_VERIFIKASI_POLDA, $messageLicense);
                }
                $respReceiveLicenseStatus = $OSSAPI->receiveLicenseStatus($sio->checklist->id_izin, $messageLicense);
                if ($respReceiveLicenseStatus->isServerError()) {
                    // TODO Server error OSS
                }
            }
            if ($isOperatorMabes) {
                if ($sio->validasi_hasil_audit && $sio->validasi_surat_rekom) {
                    $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_MABES, 'Dokumen sedang diverifikasi oleh Operator Mabes');
                    sleep(1);
                    if (role('operator_mabes')){
                        // Proses ke BKPM hanya apabila verifikasi sudah selesai pada operator mabes tingkat II (Pak Ginting)
                        $respReceiveLicense = $OSSAPI->receiveLicenseAttachment($sio->checklist->id_izin);
                        if ($respReceiveLicense->isSuccessful()){
                            $this->updateStatusSio($sio->id, $this->statusSioService::LOLOS_VERIFIKASI_MABES, 'Dokumen lolos verifikasi Operator Mabes');
                        }
                        if ($respReceiveLicense->isServerError()) {
                            throw new HttpClientException($respReceiveLicense->getData(true)['message']);
                        }
                    }
                } else {
                    $message = 'Dokumen persayaratan BUJP dinyatakan tidak valid oleh Operator Mabes';
                    if (!$sio->validasi_hasil_audit) {
                        $message = 'Dokumen Audit tidak valid oleh Operator Mabes. Keterangan: ' . $sio->keterangan_validasi_hasil_audit;
                    } elseif (!$sio->validasi_surat_rekom) {
                        $message = 'Dokumen Surat Rekomendasi tidak valid oleh Operator Mabes. Keterangan: ' . $sio->keterangan_validasi_surat_rekom;
                    }
                    $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_MABES, $message);
                    sleep(1);
                    $this->updateStatusSio($sio->id, $this->statusSioService::DIVERIFIKASI_POLDA, $message . '. Dikembalikan ke Operator Polda untuk diperbaiki dan diverifikasi ulang.');
                }
            }
        }
    }

    public function delete($id)
    {
        $sio = RiwayatSio::query()->find($id);
        $sio->statusSios()->detach();
        $sio->dokumens()->delete();
        $sio->delete();
    }
}
