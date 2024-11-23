<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class KegiatanPetugasPolmasExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $kegiatanPetugasPolmas;
    private $is_template;
    private $view_path = 'excel.template-laporan.binpolmas.kegiatan-petugas-polmas';
    private bool $is_bagopsnalev_polda;

    public function __construct(bool $is_template = false)
    {
        $this->kegiatanPetugasPolmas = new KegiatanPetugasPolmasService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = roles(['operator_bagopsnalev_polda']);
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
                $data['satuans'] = ApiHelper::getChildSatuanByKodeSatuan(auth()->user()->personel->polda, true);
            }

            return view($this->view_path, $data);
        }

        $laporans = $this->kegiatanPetugasPolmas->export(request());

        return view($this->view_path, ['laporans' => $laporans]);
    }
}
