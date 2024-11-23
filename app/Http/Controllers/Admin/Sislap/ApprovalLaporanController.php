<?php

namespace App\Http\Controllers\Admin\Sislap;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\ApprovalLaporanStoreRequest;
use App\Models\Sislap\ApprovalLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ApprovalLaporanController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(ApprovalLaporanStoreRequest $request)
    {
        try {
            $user   = auth()->user()->load('personel');
            $levels = explode('_', $user->role());
            $level  = end($levels);
            $is_approve = $request->is_approve;

            foreach ($request->approvable_id as $id){
                if ($request->is_approve){
                    $keterangan = 'Dokumen diterima oleh '. $level .' ('. $user->personel->nama .')';
                } elseif (is_null($request->is_approve)){
                    if (role('operator_bagopsnalev_mabes')){
                        $is_approve = true;
                        $keterangan = 'Dokumen diterima oleh '. $level .' ('. $user->personel->nama .')';
                    } else {
                        $keterangan = 'Laporan diajukan oleh '. $user->personel->nama .  '('. $user->personel->$level.')' .' untuk proses approval';
                    }
                } else {
                    $keterangan = 'Laporan ditolak: ' . $request->keterangan;
                }
                ApprovalLaporan::create([
                    'approvable_id'     => $id,
                    'approvable_type'   => $request->approvable_type,
                    'is_approve'        => $is_approve,
                    'approver'          => !is_null($is_approve) ? $user->id : null,
                    'keterangan'        => $keterangan,
                    'level'             => $level,
                ]);
            }
            return $this->responseSuccess([
                'message' => 'Sukses mengirimkan approval laporan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    /*
     * Specific For Approval Laporan Semester BUJP
     * */
    public function storeApprovalByBujp(ApprovalLaporanStoreRequest $request)
    {
        try {
            $user   = auth()->user()->load('bujp');
            $levels = explode('_', $user->role());
            $level  = end($levels);
            $is_approve = $request->is_approve;

            foreach ($request->approvable_id as $id) {
                $nama_bujp = $user->bujp->nama_badan_usaha;

                $keterangan = 'Laporan diajukan oleh '. $nama_bujp .' ke Mabes POLRI Tingkat I untuk proses approval';

                ApprovalLaporan::create([
                    'approvable_id'     => $id,
                    'approvable_type'   => $request->approvable_type,
                    'is_approve'        => $is_approve,
                    'approver'          => !is_null($is_approve) ? $user->id : null,
                    'keterangan'        => $keterangan,
                    'level'             => $level,
                ]);
            }
            return $this->responseSuccess([
                'message' => 'Sukses mengirimkan approval laporan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function show(ApprovalLaporan $approvalLaporan)
    {
        //
    }

    public function edit(ApprovalLaporan $approvalLaporan)
    {
        //
    }

    public function update(Request $request, ApprovalLaporan $approvalLaporan)
    {
        //
    }

    public function destroy(ApprovalLaporan $approvalLaporan)
    {
        //
    }

    public function listPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor = $request->model::query()
            ->when(isset($request->range) && $request->range === 'monthly', fn ($q) =>
                $q->whereYear('created_at', explode('-', $request->date)[0])
                  ->whereMonth('created_at', explode('-', $request->date)[1])
            )
            ->when(isset($request->range) || $request->range === 'daily', fn ($q) =>
                $q->whereDate('created_at', $request->date)
            )
            ->where('polda', $polda)
            ->pluck('id', Schema::hasColumn(
                (new $request->model())->getTable(), 'polres')
                ? 'polres'
                : 'satker'
            )
            ->toArray();

        $status_lapor = [];
        $can_send_approval = true;
        foreach($polres_list as $polres) {
            if (match($polda) {
                'POLDA DIY'        => $polres['nama_satuan'] === 'POLRES SLEMAN',
                'POLDA MALUT'      => $polres['nama_satuan'] === 'POLRES TIDORE',
                'POLDA BENGKULU'   => $polres['nama_satuan'] === 'POLRES BENGKULU',
                'POLDA KALTIM'     => in_array($polres['nama_satuan'], ['POLRES MAHAKAM ULU', 'POLRES KOLAKA TIMUR']),
                'POLDA KEP. BABEL' => $polres['nama_satuan'] === 'POLRESTA PANGKAL PINANG',
                default => false,
            }) continue;

            $status = collect(array_keys($polres_sudah_lapor))->contains($polres['nama_satuan']);
            $status_lapor[] = [
                'nama_satuan' => $polres['nama_satuan'],
                'status' => $status,
            ];
            $can_send_approval = $can_send_approval && $status;
        }

        return response()->json([
            'status_lapor' => $status_lapor,
            'can_send_approval' => $can_send_approval,
            'laporan_ids' => collect(array_values($polres_sudah_lapor))
        ]);
    }

    public function listCartenz(Request $request)
    {
        $satuan_default = [
            'KABUPATEN PEGUNUNGAN BINTANG',
            'KABUPATEN YAHUKIMO',
            'KABUPATEN INTAN JAYA',
            'KABUPATEN PUNCAK',
            'KABUPATEN NDUGA',
            'KABUPATEN DOGIYAI',
            'KOTA JAYAPURA',
            'KABUPATEN MIMIKA',
            'KABUPATEN JAYAWIJAYA',
        ];

        $has_report = $request->model::whereDate('created_at', $request->date)
                               ->pluck('id', 'daops')
                               ->toArray();

        $status_lapor = [];
        $can_send_approval = true;

        foreach($satuan_default as $item) {
            $status = collect(array_keys($has_report))->contains($item);
            $status_lapor[] = [
                'nama_satuan' => $item,
                'status' => $status,
            ];
            $can_send_approval = $can_send_approval && $status;
        }

        return response()->json([
            'status_lapor' => $status_lapor,
            'can_send_approval' => $can_send_approval,
            'laporan_ids' => collect(array_values($has_report))
        ]);
    }
}
