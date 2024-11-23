<?php

namespace App\Mail;

use App\Models\RiwayatSio;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class TidakLulusAuditMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var RiwayatSio
     */
    private $riwayatSio;

    public function __construct(RiwayatSio $riwayatSio)
    {
        $this->riwayatSio = $riwayatSio;
    }

    public function build()
    {
        return $this->subject('Informasi Tidak Lulus Audit Rekomendasi Pengurusan SIO')
            ->markdown('emails.markdown.tidak-lulus-audit', [
                'url' => route('bujp.sio.show', ['id_izin' => $this->riwayatSio->id_izin, 'pengajuan_id' =>$this->riwayatSio->id]),
                'nama_perusahaan' => $this->riwayatSio->checklist->nib->nama_perseroan,
                'riwayat_sio' => $this->riwayatSio
            ]);
    }
}
