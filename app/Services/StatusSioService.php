<?php


namespace App\Services;



use App\Repositories\Abstracts\StatusSioRepositoryAbstract;
use App\Services\Interfaces\StatusSioServiceInterface;

class StatusSioService implements StatusSioServiceInterface
{
    const DITERIMA_POLDA            = 1;
    const DIVERIFIKASI_POLDA        = 2;
    const LOLOS_VERIFIKASI_POLDA    = 3;
    const DIVERIFIKASI_MABES        = 4;
    const LOLOS_VERIFIKASI_MABES    = 5;
    const SIO_BARU_TERBIT           = 6;
    /**
     * @var StatusSioRepositoryAbstract
     */
    private $statusSioRepository;

    public function __construct(StatusSioRepositoryAbstract $statusSioRepository)
    {
        $this->statusSioRepository = $statusSioRepository;
    }


    public function getSelectData()
    {
        return $this->statusSioRepository
            ->getFilterWithAllData(request()->all(), ['id', 'status'])
            ->map(function ($item){
                return [
                    'id' => $item['id'],
                    'text' => $item['id'] . '. ' . strip_tags($item['status'])
                ];
            });
    }
}
