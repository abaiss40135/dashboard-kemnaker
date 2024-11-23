<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Nonlapbul\LapharTppoService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class LapharTppoExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.laphar-tppo';
    private $is_bagopsnalev_polda;

    public function __construct(bool $is_template = false)
    {
        $this->service = new LapharTppoService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = auth()->user()->haveRole('operator_bagopsnalev_polda');
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
               $data['satuans'] = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true) ?? [];
            }
            return view($this->path, $data);
        }

        $collection = $this->service->export(request());

        return view($this->path, [
            'laporans' => $collection,
        ]);
    }
}
