<?php


namespace App\Services;


use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use App\Repositories\LaporanPublikRepository;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class LaporanPublikService implements Interfaces\LaporanPublikServiceInterface
{
    protected $laporanPublikRepository, $laporanInformasiRepository, $keywordService;

    public function __construct(LaporanPublikRepository $laporanPublikRepository, LaporanInformasiRepositoryAbstract $laporanInformasiRepository, KeywordServiceInterface $keywordService)
    {
        $this->laporanPublikRepository = $laporanPublikRepository;
        $this->laporanInformasiRepository = $laporanInformasiRepository;
        $this->keywordService = $keywordService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatatable()
    {
        $query = $this->laporanPublikRepository
            ->getFilterWithQuery(array_merge(request()->all(), ['user_id' => auth()->user()->id]))
             ->with('laporan_informasi.keywords:keyword');

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="'.route('laporan-publik.edit', $collection->id) .'" data-id="'.$collection->id.'" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>';
                $button .= '&nbsp;<a data-id="'.$collection->id.'" class="btn btn-sm btn-danger btn-delete my-1"><i class="far fa-trash-alt"></i></a>';
                return $button;
            })
             ->addColumn('keyword', function ($collection) {
                 return isset($collection->laporan_informasi->keywords) ? $collection->laporan_informasi->keywords->implode('keyword', ', ') : '';
             })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $laporanPublik = Arr::except($data, ['laporan_informasi']);
        $laporanPublik['user_id'] = auth()->user()->id;

        try {
            $laporanPublik = $this->laporanPublikRepository->create($laporanPublik);
             $this->saveRelatedData($data, $laporanPublik);
        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function update(array $data, $id)
    {
        $laporanPublik = Arr::except($data, ['laporan_informasi']);

        try {
            $this->laporanPublikRepository->update($laporanPublik, $id);
             $this->updateRelatedData($data, $this->laporanPublikRepository->find($id));
        } catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

     private function saveRelatedData(array $data, $laporanPublik)
     {
         /**
          * Laporan Informasi
          */
         $laporanInformasi = $this->laporanInformasiRepository->create(array_merge($data['laporan_informasi'], [
             'form_id' => $laporanPublik->id,
             'form_type' => $this->laporanPublikRepository->model()
         ]));
         $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $laporanInformasi);
     }

     private function updateRelatedData(array $data, $laporanPublik)
     {
         /**
          * Laporan Informasi
          */
         if (isset($laporanPublik->laporan_informasi->id)){
             $this->laporanInformasiRepository->update(array_merge($data['laporan_informasi'], [
                 'form_id' => $laporanPublik->id,
                 'form_type' => $this->laporanPublikRepository->model()
             ]), $laporanPublik->laporan_informasi->id);
             if (isset($data['laporan_informasi']['keyword'])){
                $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $this->laporanInformasiRepository->find($laporanPublik->laporan_informasi->id));
             }
         } else {
             $laporanInformasi = $this->laporanInformasiRepository->create(array_merge($data['laporan_informasi'], [
                 'form_id' => $laporanPublik->id,
                 'form_type' => $this->laporanPublikRepository->model()
             ]));
             if (isset($data['laporan_informasi']['keyword'])){
                 $this->keywordService->syncKeywords($data['laporan_informasi']['keyword'], $data['tanggal'], $laporanInformasi);
             }
         }
     }
}
