<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Models\Provinsi;
use App\Models\VideoBoth;
use App\Services\BothService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BothController extends Controller
{
    use FileUploadTrait;
    private $bothService;

    public function __construct()
    {
        $this->bothService = new BothService();
    }

    public function index () {
        return view('administrator.both');
    }

    public function datatable(Request $r) {
        return $this->bothService->getDataTable($r);
    }

    public function destroy($id) {
        try {
            $this->bothService->delete($id);

            return $this->responseSuccess(['message' => 'BOTH berhasil dihapus']);
        } catch(\Exception $e) {
            return $this->responseError(['message' => $e]);
        }
    }
}
