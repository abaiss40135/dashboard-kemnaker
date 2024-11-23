<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Repositories\Abstracts\ProvinsiRepositoryAbstract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProvinsiService implements Interfaces\ProvinsiServiceInterface
{
    protected $provinsiRepository;

    /**
     * ProvinsiService constructor.
     * @param ProvinsiRepositoryAbstract $provinsiRepository
     */
    public function __construct(ProvinsiRepositoryAbstract $provinsiRepository)
    {
        $this->provinsiRepository = $provinsiRepository;
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function getDataAndKeyByCode()
    {
        return $this->provinsiRepository->getFilterWithAllData(request()->all(), ['code', 'name', 'polda', 'jumlah_bhabin'])->sortBy('code')->keyBy('code');
    }

    public function getSelectData()
    {
        return $this->provinsiRepository
            ->getFilterWithAllData(request()->all(), ['code', 'name', 'polda'])
            ->sortBy('code')
            ->map(fn ($item) => [
                'id'   => request()->has('id')   ? $item[request('id')]   : $item['code'],
                'text' => request()->has('text') ? $item[request('text')] : $item['polda']
            ])
            ->values();
    }

    public function getSelectProvinsiData()
    {
        return Cache::remember('provinsi.select2.data', defaultCacheTime(Constants::CACHE1DAY), function (){
            return $this->provinsiRepository
                ->getFilterWithAllData(request()->all(), ['code', 'name'])
                ->map(function ($item){
                    return [
                        'id' => (request()->has('id')) ? $item[request('id')] : $item['code'],
                        'text' => (request()->has('text')) ? $item[request('text')] : $item['name']
                    ];
                });
        });
    }

    public function getSelectDataPolda()
    {
        $request = role('operator_bhabinkamtibmas_polda') ? array_merge(request()->all(), ['polda' => Str::after(auth()->user()->personel->polda, 'POLDA ')]) : request()->all();

        return $this->provinsiRepository
            ->getFilterWithAllData($request, ['polda'])
            ->map(function ($item){
                return [
                    'id' => 'POLDA ' . $item['polda'],
                    'text' => 'POLDA ' . $item['polda']
                ];
            });
    }
}
