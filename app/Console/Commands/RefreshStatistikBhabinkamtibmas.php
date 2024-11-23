<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAkumulasiLaporanBhabinkamtibmasJob;
use App\Jobs\UpdateKlasterRutinitasBhabinkamtibmasJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class RefreshStatistikBhabinkamtibmas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:statistik-bhabinkamtibmas
                            {--lla|last_login_at=}
                            {--user_id=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update akumulasi and klaster bhabinkamtibmas';
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
     * @return mixed
     */
    public function handle()
    {
        $query = User::query()
            ->whereNotNull('last_login_at')
            ->where(function ($query){
                $query->whereDoesntHave('akumulasi_laporans')
                    ->orWhereDoesntHave('klaster_rutinitas');
            })->isBhabinkamtibmas();

        if ($this->option('last_login_at')) {
            $query->whereDate('last_login_at', '<=', $this->option('last_login_at'));
        }

        if ($this->option('user_id')) {
            $query->where('id', $this->option('user_id'));
        }

        $total = $query->count();
        echo "refreshing " . $total . " personels \n";
        $query->chunk(100, function ($users, $key) use ($total) {
            foreach ($users as $user){
                Bus::chain([
                    new UpdateAkumulasiLaporanBhabinkamtibmasJob($user),
                    new UpdateKlasterRutinitasBhabinkamtibmasJob($user)
                ])->dispatch();
                sleep(5);
            }
            echo "refreshed " . $key * 100 .'/' . $total . " personels \n";
        });
    }
}
