<?php

namespace App\Exports\Sislap\Nonlapbul\Laporan3t;

use App\Services\Interfaces\Sislap\Nonlapbul\Laporan3t\LapharTracingServiceInterface;
use App\Services\Sislap\Nonlapbul\Laporan3t\LapharTracingService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharTracing implements FromView
{
    /**
     * @var LapharTracingServiceInterface
     */
    private $lapharTracingService;
    private $is_template;

    public function __construct(LapharTracingService $lapharTracingService, bool $is_template = false)
    {
        $this->lapharTracingService = $lapharTracingService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-tracing', [
                'laphar_tracings' => []
            ]);
        }

        return view('excel.template-laporan.laphar-tracing', [
            'laphar_tracings' => $this->lapharTracingService->export(request())
        ]);
    }
}
