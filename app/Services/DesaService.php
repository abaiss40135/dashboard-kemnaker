<?php


namespace App\Services;


use App\Repositories\Abstracts\DesaRepositoryAbstract;

class DesaService implements Interfaces\DesaServiceInterface
{
    protected $desaRepository;

    /**
     * ProvinsiService constructor.
     * @param DesaRepositoryAbstract $desaRepository
     */
    public function __construct(DesaRepositoryAbstract $desaRepository)
    {
        $this->desaRepository = $desaRepository;
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

    public function getSelectData()
    {
        return $this->desaRepository
                    ->getFilterWithAllData(request()->all(), ['code', 'name'])
                    ->map(function ($item){
                        return [
                            'id' => $item['code'],
                            'text' => $item['name']
                        ];
                    })->push(['id' => 'lainnya', 'text' => 'Lainnya']);
    }
}
