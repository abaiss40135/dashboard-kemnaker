<?php


namespace App\Services;


use App\Events\MemeAdded;
use App\Http\Traits\FileUploadTrait;
use App\Models\Meme;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class MemeService implements Interfaces\MemeServiceInterface
{
    use FileUploadTrait;

    public function getDatatable(): \Illuminate\Http\JsonResponse
    {
        return DataTables::eloquent(Meme::with('tagged')->latest())
            ->addColumn('action', function ($meme) {
                $button = '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="' . $meme->id . '"><i class="fas fa-edit"></i></button>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="' . $meme->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('tags', function ($meme) {
                return $meme->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $this->uploadPath   = 'pusat-informasi';
        $this->folderName   = 'meme';
        $this->fileName     = Str::slug($data['nama_meme']) . '.' . $data['gambar']->getClientOriginalExtension();

        $meme = new Meme();
        $meme->nama_meme      = $data['nama_meme'];
        $meme->caption        = $data['caption'];
        $meme->tanggal_dibuat = now()->translatedFormat(config('app.long_date_format'));
        $meme->gambar         = $this->saveFiles($data['gambar']);
        $meme->notification   = 1;
        $meme->save();

//        send notification to specific users
        event(new MemeAdded($meme));

        $meme->tag($data['tags'] ?? []);
        return $meme->load('tagged');
    }

    public function show($id)
    {
        return Meme::with('tagged')->find($id);
    }

    public function update(array $data, $id)
    {
        $meme = Meme::find($id);
        $meme->nama_meme    = $data['nama_meme'];
        $meme->caption      = $data['caption'];
        if (\Arr::has($data, 'gambar')) {
            $this->deleteFiles($meme->gambar);

            $this->uploadPath   = 'pusat-informasi';
            $this->folderName   = 'meme';
            $this->fileName     = Str::slug($data['nama_meme']) . '.' . $data['gambar']->getClientOriginalExtension();
            $meme->gambar   = $this->saveFiles($data['gambar']);
        }
        $meme->save();

        $meme->retag($data['tags'] ?? []);
        return $meme->load('tagged');
    }

    /**
     * @throws Throwable
     */
    public function delete($id)
    {
        try {
            $meme   = Meme::find($id);
            $gambar = $meme->gambar;

            $meme->untag();
            if ($meme->delete()) {
                $this->deleteFiles($gambar);
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
