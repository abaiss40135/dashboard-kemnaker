<?php

namespace App\Services;

use App\Repositories\Abstracts\SatuanRepositoryAbstract;

class SatuanService implements Interfaces\SatuanServiceInterface
{
    protected $satuanRepository;

    /**
     * SatuanService constructor.
     * @param SatuanRepositoryAbstract $satuanRepository
     */
    public function __construct(SatuanRepositoryAbstract $satuanRepository)
    {
        $this->satuanRepository = $satuanRepository;
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
        return $this->satuanRepository
            ->getFilterWithAllData(request()->all(), ['kode_satuan', 'nama_satuan'])
            ->sortBy('kode_satuan')
            ->keyBy('kode_satuan');
    }

    public function getSelectData()
    {
        return $this->satuanRepository
            ->getFilterWithAllData(request()->all(), ['kode_satuan', 'nama_satuan'])
            ->map(function ($item) {
                return [
                    'id' => (request()->has('id')) ? $item[request('id')] : $item['kode_satuan'],
                    'text' => (request()->has('text')) ? $item[request('text')] : $item['nama_satuan']
                ];
            });
    }
}
