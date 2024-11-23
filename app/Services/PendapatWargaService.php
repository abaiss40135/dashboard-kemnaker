<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\Abstracts\PendapatWargaRepositoryAbstract;
use Illuminate\Support\Facades\Lang;

class PendapatWargaService implements Interfaces\PendapatWargaServiceInterface
{
    /**
     * @var PendapatWargaRepositoryAbstract
     */
    private $repository;

    /**
     * PendapatWargaService constructor.
     * @param PendapatWargaRepositoryAbstract $pendapatWargaRepository
     */
    public function __construct(PendapatWargaRepositoryAbstract $pendapatWargaRepository)
    {
        $this->repository = $pendapatWargaRepository;
    }

    public function getChartPendapatWarga()
    {
        $roleID = auth()->user()->getRole('id')->id;
        return $this->repository
            ->getQuery()
            ->join('dds_wargas as dds', 'pendapat_wargas.id', '=', 'dds.id')
            ->select('dds.provinsi_kepala_keluarga as provinsi', 'pendapat_wargas.jenis_pendapat as jenis')
            ->when($roleID == User::OPERATOR_BHABINKAMTIBMAS_POLDA, function ($query){
                return $query->where('dds.provinsi_kepala_keluarga', Lang::get('alias-polda')[auth()->user()->personel->polda]);
            })
            ->when(request('provinsi'), function ($query, $provinsi){
                return $query->where('dds.provinsi_kepala_keluarga', strtoupper($provinsi));
            })
            ->get()->groupBy('provinsi')->map(function ($item){
                return $item->countBy('jenis');
            })->toArray();
    }
}
