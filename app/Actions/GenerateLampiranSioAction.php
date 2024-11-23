<?php

namespace App\Actions;

use App\Http\Traits\FileUploadTrait;
use App\Models\RiwayatSio;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class GenerateLampiranSioAction
{
    use FileUploadTrait;

    /**
     * @param RiwayatSio $riwayatSio
     * @return string
     */
    public function execute(RiwayatSio $riwayatSio): string
    {
        $this->fileName = 'lampiran-sio.pdf';
        $this->uploadPath = 'bujp';
        $this->folderName = $riwayatSio->checklist->nib->nama_perseroan . '/sio/' . $riwayatSio->id_izin;

        $fullPath = $this->uploadPath . '/' . $this->folderName . '/' . $this->fileName;
        $tempPath = 'temp/' . $riwayatSio->checklist->id_izin . '/' . $this->fileName;

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.lampiran-sio', ['riwayatSio' => $riwayatSio]);
        Storage::put($tempPath, $pdf->output());

        $this->saveFiles(Storage::path($tempPath));
        $path = config('filesystems.storage_url') . $fullPath;
        \Log::info('Lampiran SIO: ' . $riwayatSio->checklist->nib->nama_perseroan, [
            'link'  => $path
        ]);
        return $path;
    }
}
