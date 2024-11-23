<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\SatkamlingService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SatkamlingExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.satkamling';
    private $is_bagopsnalev_polda;

    public function __construct(bool $is_template = false)
    {
        $this->service = new SatkamlingService();
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            $data['satuan'] = auth()->user()?->personel?->polda;
            return view($this->path, $data);
        }

        $collection = $this->service->export(request());

        return view($this->path, [
            'laporans' => $collection,
        ]);
    }
}
