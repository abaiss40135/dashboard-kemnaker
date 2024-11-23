<?php

namespace App\Jobs;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BulkStoreDataBinpolmas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $user, $levels, $level, $kode_satuan, $model, $additional_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $user, $levels, $level, $kode_satuan, $model, $additional_type = null)
    {
        $this->data = $data;
        $this->user = $user;
        $this->levels = $levels;
        $this->level = $level;
        $this->kode_satuan = $kode_satuan;
        $this->model = $model;
        $this->additional_type = $additional_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('data-fkpm-wilayah.index'));
        }

        $validated = $this->data;
        DB::transaction(function () use ($validated) {
            $additional_data = [
                'user_id' => $this->user->id,
                'kode_satuan' => $this->kode_satuan,
                'type' => $this->additional_type
            ];

            if(array_key_exists( "laporan", $validated)) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = $this->model::create(array_merge($item, $additional_data));

                    if ($this->level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $this->level,
                        ]);
                    }
                }
            } else {
                foreach ($validated['data'] as $item) {
                    $laporan = $this->model::create(array_merge($item, $additional_data));

                    if ($this->level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $this->level,
                        ]);
                    }
                }
            }
        });
    }
}
