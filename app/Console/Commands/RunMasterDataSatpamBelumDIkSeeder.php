<?php

namespace App\Console\Commands;

use Database\Seeders\MasterDataSatpamBelumDikSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class RunMasterDataSatpamBelumDikSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        run:master-data-satpam-belum-dik-seeder
        {--polda=}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run master data satpam belum dik seeder';

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
        $polda = $this->option('polda');
        $seederClass = App::make(MasterDataSatpamBelumDikSeeder::class);
        $seederClass->run($polda);
        echo "Success run master data satpam belum dik seeder for $polda";
        exit;
    }
}
