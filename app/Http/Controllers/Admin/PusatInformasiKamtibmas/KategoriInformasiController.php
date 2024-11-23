<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\KategoriInformasi\StoreKategoriInformasiRequest;
use App\Http\Requests\Administrator\PusatInformasi\KategoriInformasi\UpdateKategoriInformasiRequest;
use App\Models\KategoriInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Monolog\Handler\IFTTTHandler;
use Yajra\DataTables\DataTables;

class KategoriInformasiController extends Controller
{

    public function __construct()
    {
        $this->uploadPath = 'assets';
        $this->folderName = 'kategori-informasi';
    }

    public function datatable(DataTables $dataTables)
    {
        return $dataTables->eloquent(KategoriInformasi::query()
            ->orderBy('order'))
            ->addColumn('icon_all', function ($kategori){
                return '<img src="'. $kategori->url_icon_primary .'" alt="icon-primary"/>' .
                    '<img src="'. $kategori->url_icon_secondary .'" alt="icon-secondary"/>';
            })
            ->addColumn('action', function ($kategori){
                $button = '<button type="button" class="m-1 btn btn-sm btn-warning btn-edit" data-id="' . $kategori->id . '"><i class="fas fa-edit"></i></button>';
                if ($kategori->order != 1){
                    $button .= '<button type="button" class="m-1 btn btn-sm btn-primary btn-decrement" data-id="' . $kategori->id . '" data-order="' . $kategori->order . '"><i class="fas fa-arrow-up"></i></button>';
                }
                if ($kategori->order != KategoriInformasi::count()){
                    $button .= '<button type="button" class="m-1 btn btn-sm btn-primary btn-increment" data-id="' . $kategori->id . '" data-order="' . $kategori->order . '"><i class="fas fa-arrow-down"></i></button>';
                }
                $button .= '<button type="button" class="m-1 btn btn-sm btn-danger btn-delete" data-id="' . $kategori->id . '"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('status', function ($kategori){
                $color = $kategori->active ? 'bg-success' : 'bg-danger';
                $text = $kategori->active ? 'AKTIF' : 'TIDAK AKTIF';
                return '<span class="badge ' . $color . '">
                            ' . $text . '
                        </span>';
            })
            ->rawColumns(['icon_all', 'status', 'action'])
            ->toJson();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.kategori-informasi.index');
    }

    public function create()
    {
        //
    }

    public function store(StoreKategoriInformasiRequest $request)
    {
        try {
            $data = $this->uploadRelatedIcon($request);

            KategoriInformasi::query()->create(array_merge(
                $data, [
                    'order' => KategoriInformasi::query()->orderByDesc('order')->first('order')->order + 1
                ]
            ));
            return $this->responseSuccess([
                'message' => 'Kategori Informasi berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){

        }
    }

    public function show(KategoriInformasi $kategoriInformasi)
    {
        return $kategoriInformasi;
    }

    public function edit(KategoriInformasi $kategoriInformasi)
    {
        //
    }

    public function update(UpdateKategoriInformasiRequest $request, KategoriInformasi $kategoriInformasi)
    {
        try {
            $data = $this->uploadRelatedIcon($request);
            $kategoriInformasi->update($data);
            return $this->responseSuccess([
                'message' => 'Kategori Informasi berhasil diupdate'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function changeOrder(Request $request)
    {
        $this->validate($request, [
            'type' => ['required'],
            'order' => ['required', 'numeric', 'exists:kategori_informasi,order']
        ]);

        if (!in_array($request->input('type'), ['INCREMENT', 'DECREMENT'])){
            throw ValidationException::withMessages(['type' => 'order type invalid']);
        }

        try {
            $currentOrd = $request->input('order');
            $kategori   = KategoriInformasi::where('order', $currentOrd)->first();

            if ($request->input('type') === 'INCREMENT' && $kategori->order != KategoriInformasi::query()->count('id')){
                $target = KategoriInformasi::query()->where('order', $kategori->order + 1)->first();
                $target->update([
                    'order'=> null
                ]);
                $kategori->update(['order' => $currentOrd + 1]);
                $target->update([
                    'order' => $currentOrd
                ]);
            }
            if ($request->input('type') === 'DECREMENT' && $kategori->order != 1){
                $target = KategoriInformasi::query()->where('order', $kategori->order - 1)->first();
                $target->update([
                    'order'=> null
                ]);
                $kategori->update(['order' => $currentOrd - 1]);
                $target->update([
                    'order' => $currentOrd
                ]);
            }

            return $this->responseSuccess([
                'message' => 'Urutan kategori berhasil diperbarui.'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy(KategoriInformasi $kategoriInformasi)
    {
        try {
            $this->deleteFiles($kategoriInformasi->icon_primary);
            $this->deleteFiles($kategoriInformasi->icon_secondary);
            $kategoriInformasi->delete();
            return $this->responseSuccess([
                'message' => 'Kategori Informasi berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    /**
     * @param StoreKategoriInformasiRequest|UpdateKategoriInformasiRequest $request
     * @return array
     */
    protected function uploadRelatedIcon($request): array
    {
        $data = $request->validated();
        if ($request->hasFile('icon_primary')) {
            $this->fileName = 'icon-primary-' . Str::slug($request->name) . '.' . $request->file('icon_primary')->getClientOriginalExtension();
            $data['icon_primary'] = $this->saveFiles($request->file('icon_primary'));
        }
        if ($request->hasFile('icon_secondary')) {
            $this->fileName = 'icon-secondary-' . Str::slug($request->name) . '.' . $request->file('icon_secondary')->getClientOriginalExtension();
            $data['icon_secondary'] = $this->saveFiles($request->file('icon_secondary'));
        }
        return $data;
    }
}
