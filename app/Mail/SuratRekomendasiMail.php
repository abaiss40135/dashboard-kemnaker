<?php

namespace App\Mail;

use App\Helpers\ApiHelper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuratRekomendasiMail extends Mailable
{
    use Queueable, SerializesModels;

    private $riwayatSio;

    public function __construct($riwayatSio)
    {
        $this->riwayatSio = $riwayatSio;
    }

    public function build()
    {
        return $this->subject('Notifikasi Terbit Surat Rekomendasi')
                    ->markdown('emails.markdown.surat-rekomendasi')
                    ->with([
                        'polda' => $this->riwayatSio->polda,
                        'url' => $this->riwayatSio->url_file_surat_rekom,
                        'nama_perseroan' => $this->riwayatSio->checklist->nib->nama_perseroan
                    ]);
    }
}
