<?php

namespace App\Exports\KinerjaBhabinkamtibmas;

use App\Models\User;
use App\Repositories\Abstracts\AkumulasiLaporanBhabinkamtibmasRepositoryAbstract;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AkumulasiLaporanBhabinkamtibmasExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @var AkumulasiLaporanBhabinkamtibmasRepositoryAbstract
     */
    private $akumulasiLaporanBhabinkamtibmasRepository;
    /**
     * @var LokasiPenugasanRepositoryAbstract
     */
    private $lokasiPenugasanRepository;

    public function __construct(AkumulasiLaporanBhabinkamtibmasRepositoryAbstract $akumulasiLaporanBhabinkamtibmasRepository,
                                LokasiPenugasanRepositoryAbstract                 $lokasiPenugasanRepository)
    {
        $this->akumulasiLaporanBhabinkamtibmasRepository = $akumulasiLaporanBhabinkamtibmasRepository;
        $this->lokasiPenugasanRepository = $lokasiPenugasanRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::query()->isBhabinkamtibmas()
            ->where(function ($q) {
                $q->whereHas('mutasi', function ($query) {
                    $query->where('mutasi', false);
                })->orWhereDoesntHave('mutasi');
            })->whereHas('lokasiPenugasans', function ($query) {
                $this->lokasiPenugasanRepository->filterData(request()->all(), $query);
            })->with(['akumulasi_laporans' => function ($query) {
                $this->akumulasiLaporanBhabinkamtibmasRepository->filterData(request()->all(), $query);
            }, 'personel:user_id,nama,pangkat,handphone,satuan1,satuan2,satuan3',
                'lokasiPenugasans.provinsi:code,name',
                'lokasiPenugasans.kota:code,name',
                'lokasiPenugasans.kecamatan:code,name',
                'lokasiPenugasans.desa:code,name'])->get();
    }

    public function view(): View
    {
        return view('excel.kinerja-bhabinkamtibmas.akumulasi', ['datas' => $this->collection()]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Excel Log: ' . $exception->getMessage());
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
