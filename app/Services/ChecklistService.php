<?php


namespace App\Services;


use App\Repositories\Abstracts\ChecklistRepositoryAbstract;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ChecklistService implements Interfaces\ChecklistServiceInterface
{
    protected $checklistRepository;

    /**
     * @param ChecklistRepositoryAbstract $checklistRepository
     */
    public function __construct(ChecklistRepositoryAbstract $checklistRepository)
    {
        $this->checklistRepository = $checklistRepository;
    }

    public function getDatatable()
    {
        if (request()->ajax()) {
            $role = auth()->user()->role();
            $request = request()->all();

            $query = $this->checklistRepository->getFilterWithQuery($role == 'bujp' ? array_merge(request()->all(), ['nib' => auth()->user()->bujp->nib]) : $request)
                ->with(['riwayatSio' => function ($query) {
                    $query->where('type', request('type'));
                }, 'riwayatSio.dokumens', 'riwayatSio.status_terakhir.statusSio', 'nib', 'proyek.lokasi']);

            return DataTables::eloquent($query)
                ->addColumn('action', function ($collection) {
                    return empty($collection->riwayatSio) ? '' : '<a href="' . route('bujp.sio.show', ['id_izin' => $collection->id_izin, 'pengajuan_id' => $collection->riwayatSio->id]) . '" class="btn btn-sm btn-warning my-0"><i class="far fa-eye"></i></a>';
                })
                ->addColumn('status_dokumen', function ($collection) {
                    if (count($collection->riwayatSio->dokumens) == 0) {
                        return 'Belum input dokumen persyaratan';
                    }
                    return $collection->riwayatSio->status_terakhir->statusSio->status;
                })
                ->editColumn('flag_perpanjangan', function ($collection) {
                    return ($collection->flag_perpanjangan === 'N')
                        ? 'Pengajuan Baru'
                        : 'Perpanjangan';
                })
                ->editColumn('nomor_proyek', function ($collection) {
                    return $collection->proyek->nomor_proyek ?? "Belum Memiliki Proyek";
                })
                ->editColumn('tanggal_pengajuan', function ($collection) {
                    return Carbon::parse($collection->tanggal_pengajuan)->translatedFormat(config('app.long_datetime_format'));
                })
                ->addColumn('status_terbit', function ($checklist) {
                    return ((isset($checklist->riwayatSio->status_terakhir) && $checklist->riwayatSio->status_terakhir->status_sio_id === 6)
                        ? '<span class="badge badge-success">Terbit</span>'
                        : '<span class="badge badge-warning">Belum Terbit</span>');
                })
                ->rawColumns(['action', 'status_dokumen', 'status_terbit'])
                ->toJson();
        }
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        return $this->checklistRepository->findBy('id_izin', $id);
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
