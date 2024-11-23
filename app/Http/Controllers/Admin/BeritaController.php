<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Berita\StoreBeritaRequest;
use App\Http\Requests\Administrator\Berita\UpdateBeritaRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Interfaces\BeritaServiceInterface;
use Illuminate\Support\Str;

class BeritaController extends Controller
{

    private $beritaService;

    public function __construct(BeritaServiceInterface $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index(){
        $this->checkPermission('berita_access');

        return view('administrator.berita.index');
    }

    public function getDatatable()
    {
        return $this->beritaService->getDatatable();
    }

    public function store(StoreBeritaRequest $request){
        try {
            $this->beritaService->store($request->validated());
            return $this->responseSuccess([
                'message' => 'Berita berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function update(UpdateBeritaRequest $request, $id)
    {
        try {
            $this->beritaService->update($request->validated(), $id);
            return $this->responseSuccess([
                'message' => 'Berita berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->beritaService->delete($id);
            return $this->responseSuccess([
                'message' => 'Berita berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function show($id)
    {
        return $this->beritaService->show($id);
    }
}
