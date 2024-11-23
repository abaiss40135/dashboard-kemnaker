<?php


namespace App\Services;


use App\Repositories\Abstracts\RoleRepositoryAbstract;
use Illuminate\Support\Str;

class RoleService implements Interfaces\RoleServiceInterface
{
    protected $roleRepository;

    /**
     * AgamaService constructor.
     * @param RoleRepositoryAbstract $roleRepository
     */
    public function __construct(RoleRepositoryAbstract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getSelectData()
    {
        return $this->roleRepository
            ->getFilterWithAllData(request()->all(), ['id', 'alias', 'name'])
            ->map(function ($item){
                return [
                    'id' => request('id') && isset($item[request('id')]) ? $item[request('id')] : $item['id'],
                    'text' => request('text') && isset($item[request('text')]) ? $item[request('text')] : $item['alias']
                ];
            });
    }
}
