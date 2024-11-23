<?php

namespace App\Services;

use App\Repositories\Abstracts\KotaRepositoryAbstract;

class KotaService implements Interfaces\KotaServiceInterface
{
    protected $kotaRepository;

    /**
     * KotaService constructor.
     */
    public function __construct(KotaRepositoryAbstract $kotaRepository)
    {
        $this->kotaRepository = $kotaRepository;
    }

    public function getSelectData()
    {
        return $this->kotaRepository
                    ->getFilterWithAllData(request()->all(), ['code', 'name'])
                    ->map(function ($item) {
                        return [
                            'id' => $item['code'],
                            'text' => $item['name'],
                        ];
                    });
    }

    public function getIdKotaMetroJaya(): array
    {
        $metro_jaya = [
            'KOTA DEPOK',
            'KOTA BEKASI',
            'KABUPATEN BEKASI',
        ];

        $banten = [
            'KOTA TANGERANG',
            'KOTA TANGERANG SELATAN',
            'KABUPATEN TANGERANG',
            'KABUPATEN BOGOR',
        ];

        return ['3216', '3603', '3275', '3276', '3671', '3674', '3201'];
    }
}
