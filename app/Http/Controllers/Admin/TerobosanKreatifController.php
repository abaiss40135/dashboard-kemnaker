<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanKegiatan\Kreatifitas;
use App\Models\Provinsi;
use App\Services\TerobosanKreatifService;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;

class TerobosanKreatifController extends Controller
{
    use FileUploadTrait;
    private $terobosanKreatifService;

    public function __construct()
    {
        $this->terobosanKreatifService = new TerobosanKreatifService();
    }

    public function index () {
        return view('administrator.terobosan-kreatif');
    }

    public function datatable(Request $r) {
        return $this->terobosanKreatifService->getDataTable($r);
    }


    public function destroy($id) {
        try {
            $this->terobosanKreatifService->delete($id);

            return $this->responseSuccess(['message' => 'Video Terobosan Kreatif berhasil dihapus']);
        } catch(\Exception $e) {
            return $this->responseError(['message' => $e]);
        }
    }
}
