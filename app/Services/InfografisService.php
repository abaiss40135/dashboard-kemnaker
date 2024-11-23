<?php


namespace App\Services;


use App\Events\InfografisAdded;
use App\Http\Traits\FileUploadTrait;
use App\Models\Infografis;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class InfografisService implements Interfaces\InfografisServiceInterface
{
    use FileUploadTrait;

    public function getDatatable(): \Illuminate\Http\JsonResponse
    {
        return DataTables::eloquent(Infografis::with('tagged')->latest())
            ->addColumn('action', function ($infografis) {
                $button = '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="' . $infografis->id . '"><i class="fas fa-edit"></i></button>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="' . $infografis->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('tags', function ($infografis) {
                return $infografis->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data): Infografis
    {
        $this->uploadPath   = 'pusat-informasi';
        $this->folderName   = 'infografis';
        $this->fileName     = Str::slug($data['judul']) . '.' . $data['gambar']->getClientOriginalExtension();

//        $infografis = new Infografis();
//        $infografis->judul          = $data['judul'];
//        $infografis->deskripsi      = $data['deskripsi'];
//        $infografis->gambar         = $this->saveFiles($data['gambar']);
//        $infografis->notification   = 1;
//        $infografis->save();

        $infografis = Infografis::create([
            'judul'         => $data['judul'],
            'deskripsi'     => $data['deskripsi'],
            'gambar'        => $this->saveFiles($data['gambar']),
            'notification'  => 1,
        ]);

        event(new InfografisAdded($infografis));

        $infografis->tag($data['tags'] ?? []);
        return $infografis->load('tagged');
    }

    public function show($id)
    {
        return Infografis::with('tagged')->find($id);
    }

    public function update(array $data, $id)
    {
        $infografis = Infografis::find($id);
        $infografis->judul      = $data['judul'];
        $infografis->deskripsi  = $data['deskripsi'];
        if (\Arr::has($data, 'gambar')) {
            $this->deleteFiles($infografis->gambar);

            $this->uploadPath   = 'pusat-informasi';
            $this->folderName   = 'infografis';
            $this->fileName     = Str::slug($data['judul']) . '.' . $data['gambar']->getClientOriginalExtension();
            $infografis->gambar = $this->saveFiles($data['gambar']);
        }
        $infografis->save();

        $infografis->retag($data['tags'] ?? []);
        return $infografis->load('tagged');
    }

    /**
     * @throws Throwable
     */
    public function delete($id)
    {
        try {
            $infografis = Infografis::find($id);
            $gambar = $infografis->gambar;

            $infografis->untag();
            if ($infografis->delete()) {
                $this->deleteFiles($gambar);
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
