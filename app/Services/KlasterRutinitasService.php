<?php

namespace App\Services;

use App\Helpers\Constants;
use App\Repositories\Abstracts\{
    KlasterRutinitasRepositoryAbstract as KlasteroAbstract,
    UserRepositoryAbstract as UserAbstract
};
use Yajra\DataTables\Facades\DataTables;

class KlasterRutinitasService implements Interfaces\KlasterRutinitasServiceInterface
{
    protected $klaster;
    private $user;

    public function __construct(KlasteroAbstract $klaster, UserAbstract $user) {
        $this->klaster = $klaster;
        $this->user = $user;
    }

    public function getDatatable()
    {
        $color = [
            Constants::RUTINITAS_AKTIF  => 'info',
            Constants::RUTINITAS_CUKUP  => 'warning',
            Constants::RUTINITAS_KURANG => 'danger',
        ];

        $query = $this->user
            ->getUserBhabinkamtibmasQuery(request()->all())
            ->where(fn ($q) => $q
                ->whereHas('mutasi', fn ($q) => $q->where('mutasi', false))
                ->orWhereDoesntHave('mutasi')
            )
            ->with([
                'latest_klaster_rutinitas',
                'latest_akumulasi_laporan',
                'personel:user_id,nama,pangkat,satuan1,satuan2,satuan3',
                'lokasiPenugasans'
            ]);

        return DataTables::eloquent($query)
            ->addColumn('status_login', function ($user) {
                $badge = $user->last_login_at ? 'success' : 'danger';
                $hasLogin = $user->last_login_at ? 'SUDAH' : 'BELUM';

                return "<span class=\"badge bg-{$badge}\">$hasLogin</span>";
            })
            ->addColumn('status_klaster', function ($user) use ($color) {
                $klaster = $user->latest_klaster_rutinitas->klaster_rutinitas;
                $badge = $color[$klaster];

                return "<span class=\"badge bg-{$badge}\">{$klaster}</span>";
            })
            ->addColumn('action', function ($user) {
                $routeprofile = route('bhabin-profile.index', ['nrp' => $user->nrp]);
                $button = "<a href=\"{$routeprofile}\" "
                    .'target="_blank" '
                    .'class="btn btn-info mb-2">'
                    .'<i class="fas fa-info-circle"></i>'
                    .'</a>';

                $button .= '&nbsp;<button type="button" '
                    .'class="btn btn-warning mb-2" '
                    ."onclick=\"setModalPermissionPersonelContent('{$user->nrp}', '{$user->id}')\">"
                    .'<i class="fas fa-key"></i>'
                    .'</button>';

                $button .= '&nbsp;<button type="button" '
                    .'title="download seluruh laporan bhabin" '
                    .'class="btn btn-success mb-2" '
                    ."onclick=\"setModalLaporanBhabinkamtibmas('{$user->nrp}')\">"
                    .'<i class="fas fa-download"></i>'
                    .'</button>';

                return $button;
            })
            ->rawColumns(['action', 'status_login', 'status_klaster'])
            ->toJson();
    }

    public function queryRequest()
    {
        return $this->klaster
            ->getFilterWithQuery(request()->all())
            ->with('personel', 'user:id,nrp,last_login_at');
    }
}
