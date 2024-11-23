<?php


namespace App\Services;


use App\Events\PaparanAdded;
use App\Http\Traits\FileUploadTrait;
use App\Repositories\Abstracts\PaparanRepositoryAbstract;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class PaparanService implements Interfaces\PaparanServiceInterface
{
    use FileUploadTrait;

    /**
     * @var PaparanRepositoryAbstract
     */
    private $paparanRepository;

    /**
     * AgamaService constructor.
     * @param PaparanRepositoryAbstract $paparanRepositoryAbstract
     */
    public function __construct(PaparanRepositoryAbstract $paparanRepositoryAbstract)
    {
        $this->paparanRepository = $paparanRepositoryAbstract;
    }

    public function getDatatable()
    {
        $query = $this->paparanRepository->getFilterWithQuery(request()->all())->latest();

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-warning btn-edit"><i class="fas fa-edit"></i></button>';
                $button .= '&nbsp;<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete"><i class="far fa-trash-alt"></i></button>';
                $button .= '&nbsp;<a href="' . route('download', ['url' => $collection->gambar]) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>';
                return $button;
            })
            ->addColumn('tags', function ($collection) {
                return $collection->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $this->uploadPath = 'pusat-informasi';
        $this->folderName = 'paparan';

        $arrayData = [
            'nama_paparan' => $data['nama_paparan'],
            'tanggal_dibuat' => Carbon::now()->translatedFormat(config('app.long_date_format')),
            'gambar' => $this->saveFiles($data['gambar']),
            'notification' => 1
        ];

        if (Arr::has($data, 'thumbnail')) {
            $this->folderName = 'paparan/thumbnail';
            $arrayData['thumbnail'] = $this->saveFiles($data['thumbnail']);
        }
        $paparan = $this->paparanRepository->create($arrayData);

//        send notification to specific users
        event(new PaparanAdded($paparan));

        if (Arr::has($data, 'tags')) $paparan->tag($data['tags']);
        return $paparan;
    }

    public function show($id)
    {
        return $this->paparanRepository->find($id)->load('tagged');
    }

    public function update(array $data, $id)
    {
        $this->uploadPath = 'pusat-informasi';
        $this->folderName = 'paparan';

        $arrayData = [
            'nama_paparan' => $data['edit_nama_paparan']
        ];
        if (Arr::has($data, 'edit_gambar')) {
            $arrayData['gambar'] = $this->saveFiles($data['edit_gambar']);
        }
        if (Arr::has($data, 'edit_thumbnail')) {
            $this->folderName = 'paparan/thumbnail/';
            $arrayData['thumbnail'] = $this->saveFiles($data['edit_thumbnail']);
        }
        $paparan = $this->paparanRepository->update($arrayData, $id);
        if (Arr::has($data, 'edit_tags')){
            $this->paparanRepository->find($id, ['id'])->retag($data['edit_tags']);
        }
        return $paparan;
    }

    /**
     * @throws \Throwable
     */
    public function delete($id)
    {
        try {
            $paparan = $this->paparanRepository->find($id, ['id', 'gambar', 'thumbnail']);
            $paparan->untag();
            $this->deleteFiles([$paparan->gambar, $paparan->thumbnail]);
            $paparan->delete();
        } catch (\Throwable $throwable) {
            throw $throwable;
        }

    }
}
