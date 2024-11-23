<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Repositories\Abstracts\AgamaRepositoryAbstract;
use Illuminate\Support\Facades\Cache;

class AgamaService implements Interfaces\AgamaServiceInterface
{
    protected $agamaRepository;

    /**
     * AgamaService constructor.
     * @param AgamaRepositoryAbstract $agamaRepository
     */
    public function __construct(AgamaRepositoryAbstract $agamaRepository)
    {
        $this->agamaRepository = $agamaRepository;
    }

    public function getSelectData()
    {
        return Cache::remember('agama.select2', defaultCacheTime(Constants::CACHE1DAY), function () {
            return $this->agamaRepository
                ->getFilterWithAllData(request()->all())
                ->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'text' => $item['nama']
                    ];
                });
        });
    }
}
