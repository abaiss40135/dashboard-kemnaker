<?php

namespace App\Http\Controllers\Pencarian;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PencarianUmumServiceInterface;
use Illuminate\Http\Request;

class PencarianInformasiController extends Controller
{
    /**
     * @var PencarianUmumServiceInterface
     */
    private $pencarianUmumService;

    public function __construct(PencarianUmumServiceInterface $pencarianUmumService)
    {
        $this->pencarianUmumService = $pencarianUmumService;
    }

    public function ajaxSearch(Request $request)
    {
        return $this->pencarianUmumService->search((string)$request->input('search'));
    }

    public function ajaxSearchGrouped(Request $request)
    {
        return $this->pencarianUmumService->grouped((string)$request->input('search'), $request->input('type'));
    }
}
