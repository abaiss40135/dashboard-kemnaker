<?php

namespace App\Http\Controllers\Bhabin;

use App\Models\AtensiPimpinan;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\Interfaces\AtensiPimpinanServiceInterface;
use Illuminate\Http\Request;

class AtensiPimpinanController extends Controller
{
    private $atensiPimpinanService;

    /**
     * AtensiPimpinanController constructor.
     * @param AtensiPimpinanServiceInterface $atensiPimpinanService
     */
    public function __construct(AtensiPimpinanServiceInterface $atensiPimpinanService)
    {
        $this->atensiPimpinanService = $atensiPimpinanService;
    }

    public function show($id){
        $atensi = $this->atensiPimpinanService->show($id);
        return view('bhabin.atensi-pimpinan.show' , compact('atensi'));
    }
}
