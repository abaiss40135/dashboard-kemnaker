<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Meme\StoreMemeRequest;
use App\Http\Requests\Administrator\PusatInformasi\Meme\UpdateMemeRequest;
use App\Models\Meme;
use App\Services\Interfaces\MemeServiceInterface;
use Illuminate\Http\Request;

class MemeController extends Controller
{

    /**
     * @var MemeServiceInterface
     */
    private $memeService;

    public function __construct(MemeServiceInterface $memeService)
    {
        $this->memeService = $memeService;
    }

    public function getDatatable()
    {
        return $this->memeService->getDatatable();
    }

    public function index(){
        return view('administrator.informasi-kamtibmas.meme.index');
    }

    public function show($id)
    {
        return $this->memeService->show($id);
    }

    public function store(StoreMemeRequest $request){
        try {
            $this->memeService->store($request->validated());
            return $this->responseSuccess([
                'message' => 'Meme berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function update(UpdateMemeRequest $request, $id)
    {
        try {
            $this->memeService->update($request->validated(), $id);
            return $this->responseSuccess([
                'message' => 'Meme berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->memeService->delete($id);
            return $this->responseSuccess([
                'message' => 'Meme berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function initializePaginate(){
        $data = Meme::latest()->paginate(10);
        return response()->json($data);
    }

    public function search(Request $request){
        $search = $request->search;
        $data = Meme::where('nama_meme' , 'ilike' , '%' . $search . '%')
            ->orWhere('caption' , 'ilike' , '%' . $search . '%')
            ->paginate(10);
        return response()->json($data);
    }
}
