<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\KawasanServiceInterface;

class KawasanController extends Controller
{
    /**
     * @var KawasanServiceInterface
     */
    private $kawasanService;

    public function __construct(KawasanServiceInterface $kawasanService)
    {
        $this->kawasanService = $kawasanService;
    }

    public function getSelect2Data()
    {
        return $this->kawasanService->getSelectData();
    }
}
