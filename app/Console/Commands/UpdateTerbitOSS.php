<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\OSS\OSSController;
use App\Models\RiwayatSio;
use Illuminate\Console\Command;

class UpdateTerbitOSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oss:sync-terbit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk melakukan pengecekan dan update status 5 BOS dengan OSS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sio = RiwayatSio::with('status_terakhir')
            ->whereNotNull('nomor_izin')
            ->whereHas('status_terakhir', fn ($q) => $q->where('status_sio_id', 5))
            ->whereDoesntHave('status_terakhir', fn ($q) => $q->where('status_sio_id', 6))
            ->select('id', 'id_izin', 'nomor_izin')
            ->get();

        $oss = new OSSController();
        foreach ($sio as $key => $izin) {
            try {
                $oss->inqueryFileDS($izin->id_izin);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}
