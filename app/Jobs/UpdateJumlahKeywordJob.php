<?php

namespace App\Jobs;

use App\Models\Keyword;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateJumlahKeywordJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Keyword
     */
    protected Keyword $keyword;

    protected int $count;

    public function __construct(Keyword $keyword, int $count)
    {
        $this->keyword = $keyword;
        $this->count = $count;
    }

    public function handle()
    {
        $this->keyword->save([
            'jumlah' => $this->count
        ]);
    }
}
