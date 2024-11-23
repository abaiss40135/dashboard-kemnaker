<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Infografis\StoreInfografisRequest;
use App\Http\Requests\Administrator\PusatInformasi\Infografis\UpdateInfografisRequest;
use App\Models\Infografis;
use App\Services\Interfaces\InfografisServiceInterface;
use Illuminate\Http\Request;

class InfografisController extends Controller
{

    /**
     * @var InfografisServiceInterface
     */
    private $infografisService;

    public function __construct(InfografisServiceInterface $infografisService)
    {
        $this->infografisService = $infografisService;
    }

    public function getDatatable()
    {
        return $this->infografisService->getDatatable();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.infografis.index');
    }

    public function show($id)
    {
        return $this->infografisService->show($id);
    }

    public function store(StoreInfografisRequest $request)
    {
        try {
            $this->infografisService->store($request->validated());
            return $this->responseSuccess([
                'message' => 'Infografis berhasil ditambahkan'
            ]);

        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function update(UpdateInfografisRequest $request, $id)
    {
        try {
            $this->infografisService->update($request->validated(), $id);
            return $this->responseSuccess([
                'message' => 'Infografis berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy($id){
        try {
            $this->infografisService->delete($id);
            return $this->responseSuccess([
                'message' => 'Infografis berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function initializePaginate(){
        $data = Infografis::latest()->paginate(10);
        return response()->json($data);
    }

    public function search(Request $request){
        $search = $request->search;
        $data = Infografis::where('judul' , 'ilike' , '%' . $search . '%')
            ->orWhere('deskripsi' , 'ilike' , '%' . $search . '%')
            ->paginate(10 , ['*'] , 'halaman');
        return response()->json($data);
    }
}
