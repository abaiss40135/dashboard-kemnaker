<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Naskah\StoreNaskahRequest;
use App\Http\Requests\Administrator\PusatInformasi\Naskah\UpdateNaskahRequest;
use App\Models\Naskah;
use App\Services\Interfaces\NaskahServiceInterface;
use Illuminate\Http\Request;

class NaskahController extends Controller
{

    /**
     * @var NaskahServiceInterface
     */
    private $naskahService;

    public function __construct(NaskahServiceInterface $naskahService)
    {
        $this->naskahService = $naskahService;
    }

    public function getDatatable()
    {
        return $this->naskahService->getDatatable();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.naskah.index');
    }

    public function store(StoreNaskahRequest $request)
    {
        try {
            \DB::transaction(function () use ($request){
                $this->naskahService->store($request->validated());
            });
            return $this->responseSuccess([
                'message' => 'Naskah berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function update(UpdateNaskahRequest $request, $id)
    {
        try {
            $this->naskahService->update($request->validated(), $id);
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
            return $this->naskahService->delete($id);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function initializePaginate(){
        $data = Naskah::latest()->paginate(10);
        return response()->json($data);
    }

    public function search(Request $request){
        $search = $request->search;
        $data = Naskah::where('nama_naskah' , 'ilike' , '%' . $search . '%')
            ->orWhere('tanggal_diunggah' , 'ilike' , '%' . $search . '%')
            ->paginate(10 , ['*'] , 'halaman');
        return response()->json($data);
    }

    public function show($id)
    {
        return $this->naskahService->show($id);
    }
}
