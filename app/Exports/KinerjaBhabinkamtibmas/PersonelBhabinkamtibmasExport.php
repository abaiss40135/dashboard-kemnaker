<?php

namespace App\Exports\KinerjaBhabinkamtibmas;

use App\Helpers\ApiHelper;
use App\Models\User;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PersonelBhabinkamtibmasExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @var LokasiPenugasanRepositoryAbstract
     */
    private $lokasiPenugasanRepository;

    public function __construct(LokasiPenugasanRepositoryAbstract $lokasiPenugasanRepository)
    {
        $this->lokasiPenugasanRepository = $lokasiPenugasanRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = User::query()
            ->whereNotNull('last_login_at')
            ->isBhabinkamtibmas()
            ->whereHas('lokasiPenugasans', function ($query) {
                $this->lokasiPenugasanRepository->filterData(request()->all(), $query);
            })->with(['personel:user_id,nama,pangkat,handphone,satuan1,satuan2,satuan3',
                'lokasiPenugasans.provinsi:code,name',
                'lokasiPenugasans.kota:code,name',
                'lokasiPenugasans.kecamatan:code,name',
                'lokasiPenugasans.desa:code,name'])->get();
        return $collection->map(function ($user) {
            $sipp = ApiHelper::getPersonelByNrp($user->nrp);
            $user->dikum = collect($sipp['data']['dikum'] ?? []);
            $user->dikbangspes = collect($sipp['data']['dikbangspes'] ?? []);
            return $user;
        });
    }

    public function view(): View
    {
        return view('excel.kinerja-bhabinkamtibmas.personel', ['datas' => $this->collection()]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Excel Log: ' . $exception->getMessage());
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
