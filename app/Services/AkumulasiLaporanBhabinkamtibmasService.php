<?php


namespace App\Services;


use App\Repositories\Abstracts\AkumulasiLaporanBhabinkamtibmasRepositoryAbstract;

class AkumulasiLaporanBhabinkamtibmasService implements Interfaces\AkumulasiLaporanBhabinkamtbmasServiceInterface
{
    protected $akumulasiLaporanRepository;

    /**
     * AgamaService constructor.
     * @param AkumulasiLaporanBhabinkamtibmasRepositoryAbstract $akumulasiLaporanRepository
     */
    public function __construct(AkumulasiLaporanBhabinkamtibmasRepositoryAbstract $akumulasiLaporanRepository)
    {
        $this->akumulasiLaporanRepository = $akumulasiLaporanRepository;
    }

    public function export(array $request)
    {
        $this->akumulasiLaporanRepository->limit = 0;
        return $this->akumulasiLaporanRepository->getFilterWithAllData($request);
    }
}
