<?php

namespace App\Console;

use App\Actions\BigDataPolri\SendInformasi;
use App\Actions\BigDataPolri\SendKunjungan;
use App\Actions\BigDataPolri\SendSolving;
use App\Models\MutasiUser;
use App\Models\Polsus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if ($this->app->environment(['production', 'local', 'development'])){
            $schedule->command('telescope:prune')->weekly();
            /**
             * Refresh materialize view personel every hour
             */
            $schedule->command('refresh:materialize pusat_informasi')->hourly();
            /**
             * Refresh materialize view personel everyOddHour (rata2 butuh waktu 1jam 30menit untuk refresh materialize)
             *
             */
            $schedule->command('refresh:materialize laporan_bhabinkamtibmas --concurrently=y')->everyTwoHours();

            // $schedule->command('refresh:statistik-bhabinkamtibmas --last_login_at=2022-08-07')->cron("0 6 12 8 *");

            //mutasi personel kepolisian pensiun
            $schedule->command('mutasi:personel-pensiun')->dailyAt('00:00');
            /**
             *  Mutasi Polsus Akun where tanggal_lahir is more than 65 years monthly
             * */
            $schedule->command('command:mutasi-polsus-pensiun')->monthly()->at('13:00');

            //update status 5 SIO
            $schedule->command('oss:sync-terbit')->daily();
        }

        if($this->app->environment('api')){
            /*
            * Send Laporan to bigdata polri
            */
            $schedule->call(new SendKunjungan())->dailyAt('00:30');
            $schedule->call(new SendInformasi())->dailyAt('00:30');
            $schedule->call(new SendSolving())->dailyAt('00:30');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
