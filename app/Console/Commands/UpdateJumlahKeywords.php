<?php

namespace App\Console\Commands;

use App\Jobs\UpdateJumlahKeywordJob;
use App\Models\Keyword;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

class UpdateJumlahKeywords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:count-keyword
                            {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbarui kolom jumlah di tabel keyword';

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
        $time = now()->format('H:i:s');
        $date = ($this->option('date'))
            ? Carbon::parse($this->option('date'))->format('Y-m-d')
            : Carbon::yesterday()->format('Y-m-d');
        $date = $date.' '.$time;

        $keywords = Keyword::on('pgsql_read')->withCount('laporanInformasis')
            ->whereHas('ddsWargas', fn ($q) => $q->where('updated_at', '>', $date))
            ->orWhereHas('deteksiDinis', fn ($q) => $q->where('updated_at', '>', $date))
            ->orWhereHas('problemSolvings', fn ($q) => $q->where('updated_at', '>', $date))
            ->orWhereHas('laporanInformasis', fn ($q) => $q->where('updated_at', '>', $date))
            ->orWhereHas('pendapatWargas', fn ($q) => $q->where('updated_at', '>', $date))
            ->get();

        $chunkSize = $keywords->count() / 300;
        $batch = [];
        $keywords = $keywords->chunk((int)$chunkSize);

        foreach($keywords as $keywordChunk) {
            $chain = [];

            foreach($keywordChunk as $keyword) {
                $chain[] = new UpdateJumlahKeywordJob($keyword, $keyword->laporan_informasi_count);
            }

            $batch[] = $chain;
        }

        Bus::batch($batch)->dispatch();
    }
}
