<?php

namespace App\Services;

use App\Events\JukrahAdded;
use App\Http\Traits\FileUploadTrait;
use App\Models\Jukrah;
use App\Services\Interfaces\DatatableServiceInterface;
use App\Services\Interfaces\ResourceServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class JukrahService implements DatatableServiceInterface, ResourceServiceInterface
{
    use FileUploadTrait;

    private function setPathFile(string $fileName)
    {
        $this->uploadPath = 'jukrah';
        $this->folderName = Carbon::now()->isoFormat('YYYY_MM_DD');
        $this->fileName = $fileName;
    }

    public function getDatatable(): \Illuminate\Http\JsonResponse
    {
        $query = Jukrah::query()->when(
            in_array(request()->get('type'), Jukrah::TYPE),
            fn ($q) => $q->where('type', request()->get('type'))
        );

        return DataTables::eloquent($query)
            ->addColumn('action', function ($jukrah) {
                return '<button type="button" class="m-1 btn btn-warning btn-edit" data-id="'.$jukrah->id.'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="m-1 btn btn-danger btn-delete" data-id="'.$jukrah->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $this->setPathFile(Str::slug($data['nama']).'.'.$data['file']->getClientOriginalExtension());
        $jukrah = Jukrah::create([
            'nama' => $data['nama'],
            'file' => $this->saveFiles($data['file']),
            'type' => $data['type'] ?? Jukrah::TYPE[0]
        ]);

//        send notification to specific user
        event(new JukrahAdded($jukrah));

        return $jukrah;
    }

    public function show($id)
    {
        return Jukrah::where('id', $id)->first();
    }

    public function update(array $data, $id)
    {
        $jukrah = Jukrah::find($id);
        $jukrah->nama = $data['nama'];

        if (isset($data['file']))
        {
            $this->deleteFiles($jukrah->file);
            $this->setPathFile(Str::slug($data['nama']).'.'.$data['file']->getClientOriginalExtension());
            $jukrah->file = $this->saveFiles($data['file']);
        }

        $jukrah->save();
        return $jukrah;
    }

    public function delete($id)
    {
        try {
            $jukrah = Jukrah::where('id', $id)->first();
            $file = $jukrah->file;

            if ($jukrah->delete()) {
                $this->deleteFiles($file);
            }
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }
}
