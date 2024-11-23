<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Repositories\Abstracts\SukuRepositoryAbstract;
use Illuminate\Support\Facades\Cache;

class SukuService implements Interfaces\SukuServiceInterface
{
    protected $sukuRepository;

    /**
     * SukuService constructor.
     * @param SukuRepositoryAbstract $sukuRepository
     */
    public function __construct(SukuRepositoryAbstract $sukuRepository)
    {
        $this->sukuRepository = $sukuRepository;
    }

    public function getSelectData()
    {
        return Cache::remember('suku.select2.data', defaultCacheTime(Constants::CACHE1DAY), function () {
            return $this->sukuRepository
                ->getFilterWithAllData(request()->all())
                ->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['nama']
                    ];
                })->all();
        });
    }
}
