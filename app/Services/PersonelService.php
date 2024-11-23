<?php


namespace App\Services;


use App\Helpers\ApiHelper;
use App\Repositories\Abstracts\PersonelRepositoryAbstract;
use App\Repositories\Abstracts\UserRepositoryAbstract;
use Yajra\DataTables\Facades\DataTables;

class PersonelService implements Interfaces\PersonelServiceInterface
{
    protected $personelRepository;
    /**
     * @var UserRepositoryAbstract
     */
    private $userRepository;

    /**
     * AgamaService constructor.
     * @param PersonelRepositoryAbstract $personelRepository
     */
    public function __construct(PersonelRepositoryAbstract $personelRepository, UserRepositoryAbstract $userRepository)
    {
        $this->personelRepository = $personelRepository;
        $this->userRepository = $userRepository;
    }

    public function getDatatable()
    {
        // TODO: Implement getDatatable() method.
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        try {
            return $this->personelRepository->find($id);
        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function showByNrp($nrp)
    {
        try {
            return $this->personelRepository->findBy('nrp', $nrp);
        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
