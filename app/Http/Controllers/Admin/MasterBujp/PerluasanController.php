<?php

namespace App\Http\Controllers\Admin\MasterBujp;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use Illuminate\Http\Request;

class PerluasanController extends Controller
{
    protected $riwayatSioService;

    /**
     * PerluasanController constructor.
     * @param RiwayatSioServiceInterface $riwayatSioService
     */
    public function __construct(RiwayatSioServiceInterface $riwayatSioService)
    {
        $this->riwayatSioService = $riwayatSioService;
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

        if (request()->ajax()) return $this->riwayatSioService->getDatatable('PERLUASAN');

        return view('administrator.bujp-satpam.surat-izin', [
            'validation' => $request->validation
        ]);
    }
}
