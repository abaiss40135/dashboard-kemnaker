<?php

namespace App\Services\Interfaces\Sislap\Nonlapbul\Laporan3t;

use App\Services\Interfaces\ExportInterface;

interface LapharTracingServiceInterface extends ExportInterface
{
    public function search(array $request);
}
