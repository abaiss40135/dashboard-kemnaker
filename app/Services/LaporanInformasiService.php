<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Keyword;
use App\Models\LaporanPublik;
use App\Models\Problem_solving;
use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use Carbon\Carbon;

class LaporanInformasiService implements Interfaces\LaporanInformasiServiceInterface
{
    protected $laporanInformasiRepository;

    /**
     * AgamaService constructor.
     * @param LaporanInformasiRepositoryAbstract $laporanInformasiRepository
     */
    public function __construct(LaporanInformasiRepositoryAbstract $laporanInformasiRepository)
    {
        $this->laporanInformasiRepository = $laporanInformasiRepository;
    }

    public function filter(array $filter)
    {
        return response()->json([
            'laporan' => $this->formatLaporan($this->laporanInformasiRepository
                ->getFilterWithQuery($filter)
                ->latest()
                ->with(['form'])
                ->paginate($this->laporanInformasiRepository->recordPerPage)),
            'keyword' => $this->getPopularKeywordRelatedFormulir($filter),
            'polda' => $this->getMapPath($this->getPoldaFromFormulir($filter))
        ]);
    }

    public function getProvinceStatistics(array $filter)
    {
        return response()->json([
            'totalToday' => $this->laporanInformasiRepository->getFilterWithQuery(array_merge($filter, ['today' => true]))->count(),
            'total' => $this->laporanInformasiRepository->getFilterWithQuery($filter)->count()
        ]);
    }

    private function getPopularKeywordRelatedFormulir($filter)
    {
        return Keyword::query()
            ->where('is_valid', true)
            ->whereHas('laporanInformasis', function ($query) use ($filter){
                if (!empty($filter)) {
                    $this->laporanInformasiRepository->filterData($filter, $query);
                }
            })->orderByDesc('jumlah')->limit(60)->get(['keyword', 'jumlah'])->all();
    }

    private function getPoldaFromFormulir($filter)
    {
        return $this->laporanInformasiRepository
            ->getFilterWithQuery($filter)
            ->whereHas('form', function ($query){
                $query->getModel()->getTable() === LaporanPublik::query()->getModel()->getTable() ?
                    $query->whereNotNull('provinsi') :
                    $query->whereNotNull('polda');
            })
            ->get()
            ->map(function ($item, $key){
                return $item->form_type === LaporanPublik::class ?
                    $item->form->provinsi :
                    $item->form->polda;
            })->unique();
    }

    private function getMapPath($polda)
    {
        return $polda->map(function ($item) {
            return Constants::MAP_PATH[$item] ?? null;
        })->filter()->all();
    }

    public function getSelectData()
    {
        // TODO: Implement getSelectData() method
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    private function formatLaporan($laporanInformasi)
    {
        $laporanInformasi->each(function($laporan, $key) {
            $laporan->keyword = $laporan->keywords->pluck('keyword');
            if (!empty($laporan->form->personel)){
                $laporan->load('form.lokasi_tugas');
                $laporan->polda = $laporan->form->personel->polda . ', ' . $laporan->form->personel->polres . ', ' . $laporan->form->personel->polsek;
                $laporan->penulis = $laporan->form->personel->pangkat . ' ' . $laporan->form->personel->nama . ' ' . (isset($laporan->form->lokasi_tugas) ? $laporan->form->lokasi_tugas->lokasi_singkat : '');
                $laporan->handphone = $laporan->form->personel->handphone;
            } else {
                $laporan->polda = $laporan->form->provinsi ?? 'Tidak terdaftar pada SIPP 2.0';
                $laporan->penulis = $laporan->form->penulis ?? "";
                $laporan->handphone = "";
            }
            switch ($laporan->form_type) {
                case Dds_warga::class:
                    $laporan->tanggal = Carbon::parse($laporan->form->tanggal)->format('d-m-Y');
                    $laporan->jenis = 'DDS Warga';
                    break;
                case Deteksi_dini::class:
                    $laporan->tanggal = Carbon::parse($laporan->form->tanggal)->format('d-m-Y');
                    $laporan->jenis = 'Deteksi Dini';
                    break;
                case Problem_solving::class:
                    $laporan->tanggal = Carbon::parse($laporan->form->tanggal)->format('d-m-Y');
                    $laporan->jenis = 'Problem Solving';
                    break;
                case LaporanPublik::class:
                    $laporan->tanggal = Carbon::parse($laporan->form->tanggal)->format('d-m-Y');
                    $laporan->jenis = 'Laporan Publik';
                    break;
            }
        });
        return $laporanInformasi;
    }

    private function formatKeyword($laporanInformasi)
    {
        return $laporanInformasi->keywords->pluck('keyword')->toArray();
    }

    private function formatLokasi($laporanInformasi)
    {
        return $laporanInformasi;
    }
}
