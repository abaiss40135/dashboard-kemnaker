<?php

namespace App\Http\Controllers\Admin\KinerjaBhabinkamtibmas;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DDSWargaService;
use App\Services\DeteksiDiniService;
use App\Services\PSNonSengketaService;
use App\Services\PSSengketaService;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;

class BhabinProfileController extends Controller
{
    private DDSWargaService      $dw;
    private DeteksiDiniService   $li;
    private PSSengketaService    $ps_s;
    private PSNonSengketaService $ps_ns;

    public function __construct(DDSWargaService      $dw,
                                DeteksiDiniService   $li,
                                PSSengketaService    $ps_s,
                                PSNonSengketaService $ps_ns)
    {
        $this->dw    = $dw;
        $this->li    = $li;
        $this->ps_s  = $ps_s;
        $this->ps_ns = $ps_ns;
    }

    public function index(Request $request)
    {
        $request->validate([
            'nrp' => 'required|min:8|max:8|exists:users,nrp'
        ]);

        $user             = User::where('nrp', $request->nrp)->first();
        $personel         = $user->personel;
        $personel['foto'] = ApiHelper::getPersonelPhoto($user->nrp);

        return view('administrator.kinerja-bhabinkamtibmas.bhabin-profile', [
            'user'     => $user,
            'personel' => $personel,
        ]);
    }

    public function ddsDatatable(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        return $this->dw->getDatatable($request->nrp);
    }

    public function ddDatatable(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        return $this->li->getDatatable($request->nrp);
    }

    public function psSengketaDatatable(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        return $this->ps_s->getDatatable($request->nrp);
    }

    public function psNonSengketaDatatable(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        return $this->ps_ns->getDatatable($request->nrp);
    }

    public function ddsDelete(Request $request, $id)
    {
        try {
            $this->dw->delete($id);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }

        return $this->responseSuccess([
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function ddDelete(Request $request, $id)
    {
        try {
            $this->li->delete($id);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }

        return $this->responseSuccess([
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function psSengketaDelete(Request $request, $id)
    {
        try {
            $this->ps_s->delete($id);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }

        return $this->responseSuccess([
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function psNonSengketaDelete(Request $request, $id)
    {
        try {
            $this->ps_ns->delete($id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
