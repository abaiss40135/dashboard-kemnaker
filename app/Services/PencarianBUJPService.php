<?php


namespace App\Services;


use App\Repositories\Abstracts\BUJPRepositoryAbstract;
use Illuminate\Support\Facades\Lang;

class PencarianBUJPService implements Interfaces\PencarianBUJPServiceInterface
{
    /**
     * @var BUJPRepositoryAbstract
     */
    private $bujpRepository;

    /**
     * AgamaService constructor.
     * @param BUJPRepositoryAbstract $bujpRepository
     */
    public function __construct(BUJPRepositoryAbstract $bujpRepository)
    {
        $this->bujpRepository = $bujpRepository;
    }

    public function list(array $request)
    {
        if (roles(['operator_polda'])){
            $request['provinsi'] = Lang::get('alias-polda.'.auth()->user()->personel->polda  ?? "");
        }
        $collection = $this->bujpRepository->getFilterWithPaginatedData($request, [
            'bujps.id', 'bujps.nama_badan_usaha', 'bujps.bidang_usaha',
            'bujps.detail_alamat', 'users.email', 'bujps.provinsi as provinsi',
            'users.last_login_at as last_login_at'
        ]);

        return response()->json($collection);
    }
}
