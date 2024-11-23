<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\{
    Helpers\ApiHelper,
    Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataOrsosmasService
};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    FromView,
    ShouldAutoSize,
    WithStrictNullComparison,
};

class DataOrsosmasExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.binpolmas.data-orsosmas';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false)
    {
        $this->service = new DataOrsosmasService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = roles(['operator_bagopsnalev_polda']);
        if ($this->is_bagopsnalev_polda) {
            $this->satuans = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true);
        }
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
                $data['satuans'] = $this->satuans;
            }

            return view($this->path, $data);
        }

        $collection = $this->service->export(request());

        return view($this->path, [
            'laporans' => $collection
        ]);
    }
}
