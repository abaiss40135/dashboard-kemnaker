<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panduan\PanduanRequest;
use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PanduanController extends Controller
{
    public function index()
    {
        return view('administrator.informasi-kamtibmas.panduan.index');
    }

    public function categoryDatatable(DataTables $dataTables)
    {
        return $dataTables->eloquent(Panduan::query()
            ->parentOnly()->with('children'))
            ->addColumn('action', function ($panduan){
                $button = '<button type="button" class="m-1 btn btn-sm btn-success" onclick="addParentPanduan(this)" data-toggle="modal" data-target="#modal-panduan" data-parent="' . $panduan->id . '"><i class="fas fa-plus"></i></button>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-type="category" data-id="' . $panduan->id . '"><i class="fas fa-edit"></i></button>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-type="category" data-id="' . $panduan->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->rawColumns(['file', 'action'])
            ->toJson();
    }

    public function datatable(DataTables $dataTables)
    {
        return $dataTables->eloquent(Panduan::query()
            ->parentOnly())
            ->addColumn('sub_panduan', function ($panduan){
                return $panduan->parent->title;
            })
            ->addColumn('file', function ($panduan){
                return '<a target="_blank" href="' . $panduan->file . '" >Lihat Panduan</a>';
            })
            ->addColumn('action', function ($panduan){
                $button = '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="' . $panduan->id . '"><i class="fas fa-edit"></i></button>';
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="' . $panduan->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->rawColumns(['file', 'action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(PanduanRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('file')) {
                $this->folderName = "panduan";
                $this->fileName = $request->title . '-' . Str::slug(strtolower($request->title)) . '.' . $request->file->getClientOriginalExtension();
                $data["file"] = $this->saveFiles($request->file);
            }

            Panduan::query()->create($data);

            return $this->responseSuccess([
                'message' => ($request->type == "kategori" ? "Kategori " : '') . 'Panduan berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $panduan = Panduan::find($id)->load("parent");

        return response()->json($panduan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(PanduanRequest $request, $id)
    {
        try {
            $data = [
                "title" => $request->title,
            ];

            if($request->file("file")) {
                $parent = Panduan::find($request->parent_id);
                $this->deleteFiles($parent->file);

                $this->fileName = $parent->title . '-' . Str::slug(strtolower($request->title)) . '.' . $request->file("file")->getClientOriginalExtension();
                $data["file"] = $this->saveFiles($request->file("file"));
                $data["parent_id"] = $request->parent_id;
            }

            Panduan::find($id)->update($data);

            return $this->responseSuccess([
                'message' => ($request->type == 'panduan' ? "Panduan Penggunaan" : 'Kategori Panduan') . ' berhasil diubah'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $panduan = Panduan::find($id);
            $this->deleteFiles($panduan->getRawOriginal('file'));
            $panduan->delete();

            return $this->responseSuccess([
                'message' => 'Panduan Penggunaan yang dipilih berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return $this->responseError($e);
        }
    }

    public function getAllParent()
    {
        $parents = Panduan::where("parent_id", null)->get(["id", "title"]);
        return response()->json($parents->toArray());
    }

    public function addParent(Request $request)
    {
        try {
            Panduan::create([
                "title" => $request->new_parent
            ]);

            return $this->getAllParent();
        } catch(\Exception $e) {
            return $this->responseError($e);
        }
    }

    public function getAllChild()
    {
        $child = Panduan::where("parent_id", '!=', null)->with("parent")->get();

        return response()->json($child);
    }

    public function deleteParent($id)
    {
        $parent = Panduan::find($id);

        foreach($parent->children as $child) {
            $this->deleteFiles($child->getRawOriginal('file'));
        }

        $parent->children()->delete();
        $parent->delete();

        return $this->responseSuccess([
            'message' => 'Kategori Panduan yang dipilih berhasil dihapus'
        ]);
    }
}
