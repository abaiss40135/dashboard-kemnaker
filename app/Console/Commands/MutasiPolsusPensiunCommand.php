<?php

namespace App\Console\Commands;

use App\Models\MutasiUser;
use App\Models\Polsus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MutasiPolsusPensiunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mutasi-polsus-pensiun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mutasi Polsus account where tanggal_lahir is more than 65 years monthly';

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
        Polsus::filterPolsusAktif()
            ->where('tanggal_lahir', '<=', Carbon::now()->subYears(56))
            ->chunk(100, function ($polsuses) {
                foreach ($polsuses as $polsus) {
                    $polsus->update('status_pensiun', 1);
                }
            });
    }
}
