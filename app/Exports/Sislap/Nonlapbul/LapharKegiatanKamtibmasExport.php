<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Helpers\ApiHelper;
use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\ListKegiatan;
use App\Services\Sislap\Nonlapbul\LapharKegiatanKamtibmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class LapharKegiatanKamtibmasExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.laphar-kegiatan-kamtibmas';
    private $is_bagopsnalev_polda;

    public function __construct(bool $is_template = false)
    {
        $this->service = new LapharKegiatanKamtibmasService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = auth()->user()->haveRole('operator_bagopsnalev_polda');
    }

    public function view(): View
    {
        $listKegiatan = ListKegiatan::query()
                            ->pluck('nama', 'id');
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
                $data['kegiatans'] = $listKegiatan;
               $data['satuans'] = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true) ?? [];
            }
            return view($this->path, $data);
        }

        $collection = $this->service->export(request());

        return view($this->path, [
            'kegiatans' => $listKegiatan,
            'laporans' => $collection,
        ]);
    }
}
