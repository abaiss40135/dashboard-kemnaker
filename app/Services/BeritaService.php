<?php


namespace App\Services;


use App\Http\Traits\FileUploadTrait;
use App\Models\Berita;
use App\Repositories\Abstracts\BeritaRepositoryAbstract;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BeritaService implements Interfaces\BeritaServiceInterface
{
    use FileUploadTrait;

    public function __construct(BeritaRepositoryAbstract $beritaRepository)
    {
        $this->beritaRepository = $beritaRepository;
    }

    public function getDatatable(): \Illuminate\Http\JsonResponse
    {
        return DataTables::eloquent(Berita::with('tagged')->latest())
            ->addColumn('action', function ($berita) {
                return '<button type="button" class="m-1 btn btn-warning btn-edit" data-id="'.$berita->id.'">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="m-1 btn btn-danger btn-delete" data-id="'.$berita->id.'">
                    <i class="fas fa-trash-alt"></i>
                </button>';
            })
            ->addColumn('tags', function ($berita) {
                return $berita->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getBeritaBinmas()
    {
        if (request()->ajax()){
            return $this->beritaRepository
                        ->getFilterWithPaginatedAjaxData(request()->all());
        }
        return $this->beritaRepository->getFilterWithPaginatedData(request()->all());
    }

    public function store(array $data)
    {
        $this->uploadPath   = 'pusat-informasi';
        $this->folderName   = 'berita';
        $this->fileName     = Str::slug($data['judul']) . '.' . $data['gambar']->getClientOriginalExtension();

        $berita = new Berita();
        $berita->judul          = $data['judul'];
        $berita->pembuat_berita = $data['pembuat_berita'];
        $berita->isi_berita     = $data['isi_berita'];
        $berita->tanggal_dibuat = now()->translatedFormat(config('app.long_date_format'));
        $berita->gambar         = $this->saveFiles($data['gambar']);
        $berita->user_id        = auth()->user()->id;
        $berita->save();

        $berita->tag($data['tags'] ?? []);
        return $berita->load('tagged');
    }

    public function show($id)
    {
        return Berita::with('tagged')->find($id);
    }

    public function update(array $data, $id)
    {
        $berita = Berita::find($id);
        $berita->judul          = $data['judul'];
        $berita->pembuat_berita = $data['pembuat_berita'];
        $berita->isi_berita     = $data['isi_berita'];
        $berita->user_id        = auth()->user()->id;
        if (Arr::has($data, 'gambar')) {
            $this->deleteFiles($berita->gambar);
            $this->uploadPath   = 'pusat-informasi';
            $this->folderName   = 'berita';
            $this->fileName     = Str::slug($data['judul']) . '.' . $data['gambar']->getClientOriginalExtension();
            $berita->gambar     = $this->saveFiles($data['gambar']);
        }
        $berita->save();

        $berita->retag($data['tags'] ?? []);
        return $berita->load('tagged');
    }

    /**
     * @throws Throwable
     */
    public function delete($id)
    {
        try {
            $berita   = Berita::find($id);
            $gambar = $berita->gambar;

            $berita->untag();
            if ($berita->delete()) {
                $this->deleteFiles($gambar);
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
