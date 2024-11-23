<?php


namespace App\Services;


use App\Models\PendaftaranSio;
use App\Repositories\Abstracts\NIBRepositoryAbstract;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class NIBService implements Interfaces\NIBServiceInterface
{
    protected $nibRepository;

    /**
     * AgamaService constructor.
     * @param NIBRepositoryAbstract $nibRepository
     */
    public function __construct(NIBRepositoryAbstract $nibRepository)
    {
        $this->nibRepository = $nibRepository;
    }

    public function getDatatable()
    {
        // TODO: Implement getDatatable() method.
    }

    public function getChecklistDatatable()
    {
        if (request()->ajax()){
            $query = $this->nibRepository->findBy('nib', request('nib'))
                ->checklists();

            return DataTables::eloquent($query)
                ->addColumn('action', function ($collection) {
                    return '<a href="' . route('bujp.sio.show', $collection->id) . '" data-id="' . $collection->id_izin . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                })
                ->addColumn('tanggal_pengajuan', function ($collection){
                    return $collection->riwayat_sio;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
        try {

        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function show($id)
    {
        return $this->nibRepository->find($id);
    }

    public function find($nib)
    {
        return $this->nibRepository->findBy('nib', $nib);
    }

    public function findWithAllRelation($nib)
    {
        $nib = $this->nibRepository
            ->findNomorIndukBerusahaWithAllRelation($nib);

        if (request()->expectsJson()){
            return $nib->toJson(JSON_PRETTY_PRINT);
        }
        return $nib;
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
        try {

        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        try {
            return $this->nibRepository->delete($id);
        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }
}
