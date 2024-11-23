<?php


namespace App\Services;


use App\Repositories\Abstracts\SatpamRepositoryAbstract;
use Illuminate\Support\Facades\Lang;

class SatpamService implements Interfaces\SatpamServiceInterface
{
    private $satpamRepository;

    /**
     * AgamaService constructor.
     * @param SatpamRepositoryAbstract $satpamRepositoryAbstract
     */
    public function __construct(SatpamRepositoryAbstract $satpamRepositoryAbstract)
    {
        $this->satpamRepository = $satpamRepositoryAbstract;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(array $request)
    {
        $request['has_kta'] = true;
        if (roles(['operator_polda'])){
            $request['provinsi'] = Lang::get('alias-polda.'.auth()->user()->personel->polda  ?? "");
        }
        return $this->satpamRepository
            ->getFilterWithPaginatedData($request, ['satpams.*', 'bujps.nama_badan_usaha']);
    }

    public function exportList(array $request)
    {
        return $this->satpamRepository->getFilterWithExportData($request, ['satpams.*', 'bujps.nama_badan_usaha', 'users.last_login_at']);
    }

    public function getSelect2Provinsi()
    {
        return $this->satpamRepository
            ->getFilterWithAllData(request()->all(), ['provinsi'])
            ->unique('provinsi')->values()
            ->map(function ($item){
                return [
                    'id'=> $item['provinsi'],
                    'text' => $item['provinsi'],
                ];
            });
    }
}
