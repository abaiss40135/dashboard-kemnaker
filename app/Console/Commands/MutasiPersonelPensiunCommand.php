<?php

namespace App\Console\Commands;

use App\Helpers\ApiHelper;
use App\Models\MutasiUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MutasiPersonelPensiunCommand extends Command
{
    protected $signature = 'mutasi:personel-pensiun';

    protected $description = 'Mutasi user otomatis setiap hari, berdasarkan tanggal_lahir personel dicocokkan pada data SIPP 2.0';

    public function handle()
    {
        User::hasNrp()
            ->whereHas('personel', function ($query) {
                $query->where('tanggal_lahir', '<=', Carbon::now()->subYears(58));
            })->whereDoesntHave('roles', function ($query) {
                $query->where('id', User::BHABINKAMTIBMAS_PENSIUN);
            })->whereDoesntHave('mutasi', function ($query) {
                $query->where('mutasi', true);
            })->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $sipp = ApiHelper::getPersonelByNrp($user->nrp)['data']['personel'];
                    if ($sipp['status_personel_id'] === 4) {
                        $mutasi = true;
                        //Jika user bhabinkamtibmas, maka set ke bhabinkamtibmas pensiun. Jika bukan, maka set ke operator (misal) pensiun
                        if ($user->haveRoleID([User::BHABIN, User::BHABINKAMTIBMAS_MUTASI])) {
                            $user->roles()->sync([User::BHABINKAMTIBMAS_PENSIUN]);
                            $mutasi = false;
                        }
                        MutasiUser::create([
                            'mutasi' => $mutasi,
                            'user_id' => $user->id,
                            'desc' => $sipp['status'],
                            'user_id_pengubah' => User::firstWhere('email', 'admin@bos.polri.go.id')->id
                        ]);
                    }
                }
            });
    }
}
