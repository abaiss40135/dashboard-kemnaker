<?php


namespace App\Services;


use App\Http\Traits\FileUploadTrait;
use App\Models\Naskah;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NaskahService implements Interfaces\NaskahServiceInterface
{
    use FileUploadTrait;

    public function getDatatable()
    {
        return DataTables::eloquent(Naskah::with('tagged')->latest())
            ->addColumn('action', function ($naskah) {
                $button = '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="' . $naskah->id . '"><i class="fas fa-edit"></i></button>';
                $button .= '<a href="' . route('download', ['url' => $naskah->file_naskah]) . '" class="m-1 btn btn-sm btn-primary"><i class="fas fa-download"></i></a>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="' . $naskah->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('tags', function ($naskah) {
                return $naskah->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $this->uploadPath = 'pusat-informasi';
        $this->folderName = 'naskah';
        $this->fileName = Str::slug($data['nama_naskah']) . '.' . $data['file_naskah']->getClientOriginalExtension();

        $naskah = new Naskah();
        $naskah->nama_naskah = $data['nama_naskah'];
        $naskah->tanggal_diunggah = now()->translatedFormat(config('app.long_date_format'));
        $naskah->file_naskah = $this->saveFiles($data['file_naskah']);
        $naskah->notification = 1;
        $naskah->save();

        $naskah->tag($data['tags'] ?? []);
        return $naskah;
    }

    public function show($id)
    {
        return Naskah::with('tagged')->find($id);
    }

    public function update(array $data, $id)
    {
        $naskah = Naskah::find($id);
        $naskah->nama_naskah = $data['nama_naskah'];
        if (\Arr::has($data, 'file_naskah')) {
            $this->deleteFiles($naskah->file_naskah);

            $this->uploadPath = 'pusat-informasi';
            $this->folderName = 'naskah';
            $this->fileName = Str::slug($data['nama_naskah']) . '.' . $data['file_naskah']->getClientOriginalExtension();
            $naskah->file_naskah = $this->saveFiles($data['file_naskah']);
        }
        $naskah->save();

        $naskah->retag($data['tags'] ?? []);
        return $naskah;
    }

    /**
     * @throws \Throwable
     */
    public function delete($id)
    {
        try {
            $naskah = Naskah::find($id);
            $file = $naskah->file_naskah;

            $naskah->untag();
            if ($naskah->delete()) {
                $this->deleteFiles($file);
            }

        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }
}
