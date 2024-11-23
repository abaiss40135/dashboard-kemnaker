<?php


namespace App\Services;


use App\Models\Personel;
use App\Models\User;
use App\Repositories\Abstracts\AtensiPimpinanRepositoryAbstract;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class AtensiPimpinanService implements Interfaces\AtensiPimpinanServiceInterface
{
    protected $atensiPimpinanRepository;

    /**
     * AtensiPimpinanService constructor.
     * @param AtensiPimpinanRepositoryAbstract $atensiPimpinanRepository
     */
    public function __construct(AtensiPimpinanRepositoryAbstract $atensiPimpinanRepository)
    {
        $this->atensiPimpinanRepository = $atensiPimpinanRepository;
    }

    public function getDatatable()
    {
        $query = $this->atensiPimpinanRepository->getFilterWithQuery(request()->all());

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('atensi-pimpinan.edit', ['atensi_pimpinan' => $collection->id, 'sasaran'=> $collection->sasaran]) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                $button .= '&nbsp;<a href="#" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></a>';
                return $button;
            })
            ->rawColumns(['action', 'isi'])
            ->toJson();
    }

    public function getSelectData()
    {
        return $this->atensiPimpinanRepository->getFilterWithPaginatedData(request()->all());
    }

    public function getFrontendData()
    {
        // get data for card atensi on front end
        return $this->atensiPimpinanRepository->getFilterWithPaginatedData(request()->all());
    }

    public function store(array $data)
    {
        return $this->atensiPimpinanRepository->create($data);
    }

    public function show($id)
    {
        return $this->atensiPimpinanRepository->find($id, ['id', 'judul', 'isi', 'sasaran', 'pemberi', 'created_at']);
    }

    public function update(array $data, $id)
    {
        return $this->atensiPimpinanRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->atensiPimpinanRepository->delete($id);
    }

    public function getSelectPemberiAtensi(array $data)
    {
        $result = [];
        $query = $data['query'];
        if($query)
        {
            $queryData = Personel::where('nama', 'ilike', "%$query%")
                ->orWhere('jabatan', 'ilike', "%$query%")
                ->get(['personel_id', 'nama', 'jabatan']);

            foreach($queryData as $user)
            {
                $result[] = [
                    'id' => $user->personel_id,
                    'text' => $user->jabatan . ' | ' . $user->nama
                ];
            }
        }
        else
        {
            $queryData = Personel::doesntHave('user.mutasiUsers')
                ->where('jabatan', 'ilike', '%kapolri%')
                ->orWhere('jabatan', 'ilike', '%wakapolri%')
                ->orWhere('jabatan', 'ilike', '%kabaharkam%')
                ->orWhere('jabatan', 'ilike', '%kakorbinmas%')
                ->orWhere('jabatan', 'ilike', '%dirbinpotmas%')
                ->orWhere('jabatan', 'ilike', '%dirbintibmas%')
                ->get();

            foreach($queryData as $user)
            {
                $result[] = [
                    'id' => $user->personel_id,
                    'text' => $user->jabatan . ' | ' . $user->nama
                ];
            }
        }

        return $result;
    }
}
