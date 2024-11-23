<?php

namespace App\Observers;

use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Http\Controllers\API\OSS\OSSController;
use App\Http\Traits\FileUploadTrait;
use App\Mail\SuratRekomendasiMail;
use App\Models\PendaftaranSio;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PendaftaranSioObserver
{
    use FileUploadTrait;

    /**
     * Handle the pendaftaran sio "created" event.
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function created(PendaftaranSio $pendaftaranSio)
    {
        (new OSSController())->receiveLicenseStatus($pendaftaranSio->bujp->nib, 'Dokumen Diterima oleh Polda');
    }

    /**
     * Handle the pendaftaran sio "updated" event.
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function updated(PendaftaranSio $pendaftaranSio)
    {
    }

    /**
     * Handle the pendaftaran sio "deleted" event.
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function deleted(PendaftaranSio $pendaftaranSio)
    {
        //
    }

    /**
     * Handle the pendaftaran sio "restored" event.
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function restored(PendaftaranSio $pendaftaranSio)
    {
        //
    }

    /**
     * Handle the pendaftaran sio "force deleted" event.
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function forceDeleted(PendaftaranSio $pendaftaranSio)
    {
        //
    }
}
