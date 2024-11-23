<?php


namespace App\Services;


use App\Http\Traits\FileUploadTrait;
use App\Models\Uu;
use App\Models\UuDalamPolri;
use App\Models\UuLuarPolri;
use Illuminate\Validation\ValidationException;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class RegulasiService implements Interfaces\RegulasiServiceInterface
{
    use FileUploadTrait;

    public function getDatatable()
    {
        return DataTables::eloquent($this->getModel()->newQuery()->with('tagged')->latest())
            ->addColumn('action', function ($regulasi) {
                $button ='<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="'.$regulasi->id.'"><i class="fas fa-edit"></i></button>';
                $button .= '<a href="'.route('download', ['url' => $regulasi->file_uu]).'" class="m-1 btn btn-sm btn-primary"><i class="fas fa-download"></i></a>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="'.$regulasi->id.'"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('tags', function ($regulasi) {
                return $regulasi->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $this->uploadPath   = 'pusat-informasi';
        $this->folderName   = $data['type'];
        $this->fileName     = $data['nama_uu'].'.'.$data['file_uu']->getClientOriginalExtension();
        $regulasi = $this->getModel()->newQuery()->create([
            'nama_uu'           => $data['nama_uu'],
            'deskripsi_uu'      => $data['deskripsi_uu'],
            'tanggal_diunggah'  => now()->translatedFormat(config('app.long_date_format')),
            'file_uu'           => $this->saveFiles($data['file_uu']),
            'notification'      => 1,
        ]);
        $regulasi->tag($data['tags'] ?? []);
        return $regulasi;
    }

    public function show($id)
    {
        return $this->getModel(request('type'))->newQuery()->with('tagged')->find($id);
    }

    public function update(array $data, $id)
    {
        $regulasi = $this->getModel()->newQuery()->find($id);
        $regulasi->nama_uu      = $data['nama_uu'];
        $regulasi->deskripsi_uu = $data['deskripsi_uu'];
        if (\Arr::has($data, 'file_uu')) {
            $this->deleteFiles($regulasi->file_uu);

            $this->uploadPath   = 'pusat-informasi';
            $this->folderName   = $data['type'];
            $this->fileName     = $data['nama_uu'].'.'.$data['file_uu']->getClientOriginalExtension();
            $regulasi->file_uu  = $this->saveFiles($data['file_uu']);
        }
        $regulasi->save();

        $regulasi->retag($data['tags'] ?? []);
        return $regulasi;
    }

    /**
     * @throws Throwable
     */
    public function delete($id)
    {
        try {
            $regulasi = $this->getModel()
                            ->newQuery()
                            ->find($id, ['id', 'file_uu']);
            $file     = $regulasi->file_uu;
            $regulasi->untag();
            if ($regulasi->delete()){
                $this->deleteFiles($file);
            }
        } catch (Throwable $throwable){
            throw $throwable;
        }
    }

    private function getModel($type = null)
    {
        $type = $type ?? request('type');
        if ($type === 'undang-undang') return new Uu();
        if ($type === 'internal-polri') return new UuDalamPolri();
        if ($type === 'eksternal-polri') return new UuLuarPolri();
        throw ValidationException::withMessages(['type' => 'Tipe regulasi tidak dikenali']);
    }
}
