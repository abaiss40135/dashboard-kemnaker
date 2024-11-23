<?php


namespace App\Services;


use App\Repositories\Abstracts\KawasanRepositoryAbstract;

class KawasanService implements Interfaces\KawasanServiceInterface
{
    protected $kawasanRepository;

    /**
     * KawasanService constructor.
     * @param KawasanRepositoryAbstract $kawasanRepository
     */
    public function __construct(KawasanRepositoryAbstract $kawasanRepository)
    {
        $this->kawasanRepository = $kawasanRepository;
    }

    public function getSelectData()
    {
        return $this->kawasanRepository
            ->getFilterWithAllData(request()->all())
            ->map(function ($item){
                return [
                    'id'=> $item['name'],
                    'text' => $item['name']
                ];
            });
    }
}
