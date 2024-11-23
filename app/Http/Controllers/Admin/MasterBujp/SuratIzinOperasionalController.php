<?php

namespace App\Http\Controllers\Admin\MasterBujp;

use App\Exports\BujpExport;
use App\Exports\SIOKantorPusatExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\SuratIzinOperasional\PenjadwalanAuditRequest;
use App\Http\Requests\Bujp\SuratIzinOperasional\UpdateSuratIzinOperasionalRequest;
use App\Http\Requests\Bujp\SuratIzinOperasional\ValidasiBerkasRequest;
use App\Mail\PenjadwalanAudit as MailPenjadwalanAudit;
use App\Models\RiwayatSio;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use App\Services\SIOService;
use App\Services\StatusSioService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class SuratIzinOperasionalController extends Controller
{
    protected $riwayatSioService;
    /**
     * @var SIOService
     */
    private $SIOService;
    /**
     * @var StatusSioService
     */
    private $statusSioService;

    /**
     * SuratIzinOperasionalController constructor.
     * @param RiwayatSioServiceInterface $riwayatSioService
     */
    public function __construct(RiwayatSioServiceInterface $riwayatSioService,
                                SIOService $SIOService,
                                StatusSioService $statusSioService)
    {
        $this->riwayatSioService = $riwayatSioService;
        $this->statusSioService = $statusSioService;
        $this->SIOService = $SIOService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'validation' => 'nullable|numeric|in:1,2'
        ]);

        $this->checkPermission('sio_access');

        if (request()->ajax()) return $this->riwayatSioService->getDatatable();

        return view('administrator.bujp-satpam.surat-izin', [
            'validation' => $request->validation
        ]);
    }

    /* jadwal */
    public function penjadwalan(RiwayatSio $riwayatSio, PenjadwalanAuditRequest $request)
    {

        $this->checkPermission('penjadwalan_audit_create');
        $emailPerusahaan = ($riwayatSio->checklist && $riwayatSio->checklist->nib && $riwayatSio->checklist->nib->email_perusahaan !== '-')
                            ? $riwayatSio->checklist->nib->email_perusahaan
                            : $riwayatSio->checklist->nib->email_user_proses;
        DB::beginTransaction();
        try {
            $riwayatSio->update($request->validated());
            Mail::to($emailPerusahaan)
                ->cc(config('mail.cc_email'))
                ->send(new MailPenjadwalanAudit($request->jadwal_audit, $riwayatSio));
            $this->flashSuccess('Audit berhasil dijadwalkan pada ' . Carbon::parse($riwayatSio->jadwal_audit)
                    ->translatedFormat(config('app.long_datetime_format')));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->flashError($e->getMessage());
        }
        return back();
    }

    public function validasiBerkas(ValidasiBerkasRequest $request, RiwayatSio $riwayatSio)
    {
        $this->checkPermission('sio_edit');
        $this->SIOService->validasiBerkas($request->validated(), $request->id);
        if (role('operator_polda')) {
            $keterangan = 'Dokumen diverifikasi oleh ' . $riwayatSio->polda;
            $this->SIOService->updateStatusSio($riwayatSio->id, $this->statusSioService::DIVERIFIKASI_POLDA, $keterangan);
        }
        if (role('operator_mabes')) {
            $keterangan = 'Dokumen diverifikasi oleh Operator Mabes';
            $this->SIOService->updateStatusSio($riwayatSio->id, $this->statusSioService::DIVERIFIKASI_MABES, $keterangan);
        }
        return $request->validasi == "true" ? "valid" : "invalid";
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->checkPermission('sio_show');
        $data = $this->SIOService->show($id);
        return view('administrator.bujp-satpam.show.detail-sio', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSuratIzinOperasionalRequest $request, $id)
    {
        $this->checkPermission('sio_edit');
        DB::beginTransaction();
        try {
            $this->SIOService->update($request->validated(), $id);
            $this->flashSuccess('Pendaftaran SIO berhasil diperbarui');
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
        }
        if (role('operator_polda')) {
            return redirect()->route('surat-izin-operasional.index');
        }
        return back();
    }

    public function export(Excel $excel, SIOKantorPusatExport $export)
    {
        return $excel->download($export, 'Pendaftaran SIO Baru Kantor Pusat - ' . now()->translatedFormat(config('app.long_date_without_day_format')) . '.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->checkPermission('sio_destroy');
        try {
            $this->SIOService->delete($id);
            return $this->responseSuccess([
                'message' => 'Pengajuan SIO beserta berkas dan history berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }
}
