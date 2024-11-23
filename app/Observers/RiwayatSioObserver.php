<?php

namespace App\Observers;

use App\Http\Traits\FileUploadTrait;
use App\Mail\PendaftaranSioMail;
use App\Mail\SuratRekomendasiMail;
use App\Models\RiwayatSio;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RiwayatSioObserver
{
    use FileUploadTrait;

    /**
     * Handle the riwayat sio "created" event.
     *
     * @param RiwayatSio $riwayatSio
     */
    public function created(RiwayatSio $riwayatSio)
    {
        //
    }

    /**
     * Handle the riwayat sio "updated" event.
     *
     * @param RiwayatSio $riwayatSio
     */
    public function updated(RiwayatSio $riwayatSio)
    {
        $emailPerusahaan = ($riwayatSio->checklist && $riwayatSio->checklist->nib && $riwayatSio->checklist->nib->email_perusahaan !== '-')
                            ? $riwayatSio->checklist->nib->email_perusahaan
                            : $riwayatSio->checklist->nib->email_user_proses;
        $changes = $riwayatSio->getChanges();
        if ($riwayatSio->isDirty(['polda'])) {
            Mail::to($emailPerusahaan)
                ->cc(config('mail.cc_email'))
                ->send(new PendaftaranSioMail($riwayatSio));
        }

        if ($riwayatSio->isDirty(['validasi_surat_rekom']) && $changes['validasi_surat_rekom']) {
            $emailOperator = [config('mail.cc_email')];
            $operatorMabes = User::with('personel:user_id,email')->isOperatorMabes()->get();

            foreach ($operatorMabes as $operator) {
                $emailOperator[] = filter_var($operator->personel->email ?? $operator->email, FILTER_SANITIZE_EMAIL);
            }

            Mail::to($emailPerusahaan)
                ->cc($emailOperator)
                ->send(new SuratRekomendasiMail($riwayatSio));
        }
        if ($riwayatSio->isDirty(['status_audit']) && $riwayatSio->status_audit == 2 && !empty($riwayatSio->penilaian_audit)){
            Mail::to($emailPerusahaan)
                ->cc(config('mail.cc_email'))
                ->send(new PendaftaranSioMail($riwayatSio));
        }
    }

    /**
     * Handle the riwayat sio "deleted" event.
     *
     * @param RiwayatSio $riwayatSio
     */
    public function deleted(RiwayatSio $riwayatSio)
    {
        //
    }

    /**
     * Handle the riwayat sio "restored" event.
     *
     * @param RiwayatSio $riwayatSio
     */
    public function restored(RiwayatSio $riwayatSio)
    {
        //
    }

    /**
     * Handle the riwayat sio "force deleted" event.
     *
     * @param RiwayatSio $riwayatSio
     */
    public function forceDeleted(RiwayatSio $riwayatSio)
    {
        //
    }
}
