<?php

namespace App\View\Components\Admin\PengelolaanAkun\Profile;

use App\Helpers\ApiHelper;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Personel extends Component
{
    private $user;
    private $hakAkses;

    public function __construct($user, $hakAkses)
    {
        $this->user = $user;
        $this->hakAkses = $hakAkses;
    }

    public function render(): View
    {
        $data = Cache::remember('SIPP_API_getPersonelSingkat' . $this->user->nrp, defaultCacheTime(), function () {
            return ApiHelper::getPersonelSingkatByNrp($this->user->nrp);
        });
        $aktif = $this->user->haveRoleID([User::BHABINKAMTIBMAS_PENSIUN, User::BHABINKAMTIBMAS_MUTASI]) ? 'TIDAK AKTIF' : 'AKTIF';
        return view('components.admin.pengelolaan-akun.profile.personel', [
            'hakAkses' => $this->hakAkses,
            'personel' => $data,
            'aktif' => $aktif
        ]);
    }
}
