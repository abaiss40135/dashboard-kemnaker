<?php


namespace App\Services;


use App\Repositories\Abstracts\RiwayatSioRepositoryAbstract;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class RiwayatSioService implements Interfaces\RiwayatSioServiceInterface
{
    protected $riwayatSio;

    /**
     * RiwayatSioService constructor.
     * @param RiwayatSioRepositoryAbstract $riwayatSio
     */
    public function __construct(RiwayatSioRepositoryAbstract $riwayatSio)
    {
        $this->riwayatSio = $riwayatSio;
    }

    public function getDatatable($type = 'KANTOR PUSAT')
    {
        $query = $this->riwayatSio
            ->getFilterWithQuery(array_merge(request()->all(), ['type' => $type]))
            ->with(['checklist.nib', 'status_terakhir'])
            ->hasChecklist();

        return DataTables::eloquent($query->orderByDesc('tanggal_pengajuan'))
            ->addColumn('action', function ($sio) {
                $button = '<a href="' . route('surat-izin-operasional.show', $sio->id) . '" class="btn btn-primary"> <i class="fas fa-eye"></i> </a>';
                if (can('penjadwalan_audit_create') && $sio->dokumens()->invalid()->count() == 0) {
                    $button .= '&nbsp;<button type="button" data-id="' . $sio->id . '" class="btn btn-success ' . (!$sio->status_audit ? '' : 'disabled') . '"
                                        onclick="showModalPenjadwalan(this)">
                                <i class="fas fa-calendar-alt"></i>
                              </button>';
                }
                if (can('sio_destroy')){
                    $button .= '&nbsp;<button type="button" data-id="' . $sio->id . '" class="btn btn-delete btn-danger">
                                <i class="fas fa-trash"></i>
                              </button>';
                }
                return $button;
            })
            ->addColumn('lokasi_usaha', function ($sio) {
                if (isset($sio->checklist->proyek->lokasi)){
                    return $sio->checklist->proyek->lokasi->alamat_usaha.' '.extractLocationRaw($sio->checklist->proyek->lokasi->proyek_daerah_id ?? $sio->checklist->nib->kd_daerah);
                }
                return "-";

            })
            ->addColumn('status', function ($sio) {
                $isValid = $sio->dokumens()->pluck('validasi')->toArray();
                return in_array(null, $isValid) ? 'Belum Diverifikasi' : (in_array(false, $isValid) ? 'Tidak Valid' : 'Valid');
            })
            ->addColumn('status_terbit', function ($sio) {
                return ((isset($sio->status_terakhir) && $sio->status_terakhir->status_sio_id === 6)
                    ? '<span class="badge badge-success">Terbit</span>'
                    : '<span class="badge badge-warning">Belum Terbit</span>');
            })
            ->addColumn('verifikator', function ($sio){
                return isset($sio->status_terakhir->user) ? $sio->status_terakhir->user->personel->nama : '';
            })
            ->editColumn('tanggal_pengajuan', function ($sio) {
                return Carbon::parse($sio->tanggal_pengajuan)->translatedFormat(config('app.long_date_format'));
            })
            ->addColumn('last_update', function ($sio){
                return isset($sio->status_terakhir->updated_at) ?
                    Carbon::parse($sio->status_terakhir->updated_at)->translatedFormat(config('app.long_datetime_format')) :
                    '';
            })
            ->rawColumns(['action', 'status', 'status_terbit', "lokasi_usaha"])
            ->toJson();
    }

    public function export(array $request)
    {
        return $this->riwayatSio->getFilterWithExportData($request);
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        return $this->riwayatSio->find($id);
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
