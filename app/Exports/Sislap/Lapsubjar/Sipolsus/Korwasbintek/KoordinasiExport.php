<?php

namespace App\Exports\Sislap\Lapsubjar\Sipolsus\Korwasbintek;

use App\Services\Sislap\Sipolsus\Korwasbintek\KoordinasiService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class KoordinasiExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.sipolsus.korwasbintek.koordinasi';
    private $is_bagopsnalev_polda;

    public function __construct(bool $is_template = false)
    {
        $this->service = new KoordinasiService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = auth()->user()->haveRole(['operator_bagopsnalev_polda', 'operator_polsus_polda']);
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
               $data['polda'] = auth()->user()->personel->polda;
            }
            return view($this->path, $data);
        }

        $collection = $this->service->export(request());

        return view($this->path, [
            'laporans' => $collection,
        ]);
    }
}
