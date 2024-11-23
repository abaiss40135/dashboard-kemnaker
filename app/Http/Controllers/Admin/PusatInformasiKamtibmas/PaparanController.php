<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Paparan\StorePaparanRequest;
use App\Http\Requests\Administrator\PusatInformasi\Paparan\UpdatePaparanRequest;
use App\Models\Paparan;
use App\Services\Interfaces\PaparanServiceInterface;
use Illuminate\Http\Request;

class PaparanController extends Controller
{

    /**
     * @var PaparanServiceInterface
     */
    private $paparanService;

    public function __construct(PaparanServiceInterface $paparanService)
    {
        $this->paparanService = $paparanService;
    }

    public function getDatatable()
    {
        return $this->paparanService->getDatatable();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.paparan.index');
    }

    public function create()
    {
        //
    }

    public function store(StorePaparanRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->paparanService->store($request->validated());
            $this->flashSuccess('Berhasil Menambahkan Paparan');
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            $this->flashError($exception->getMessage());
        }
        return back();
    }

    public function show($id)
    {
        return $this->paparanService->show($id);
    }

    public function update(UpdatePaparanRequest $request, $id)
    {
        \DB::beginTransaction();
        try {
            \DB::commit();
            $paparan = $this->paparanService->update($request->validated(), $id);
            return $this->responseSuccess([
                'data' => $paparan,
                'message' => 'Paparan berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            \DB::rollBack();
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                $this->paparanService->delete($id);
            });
            return $this->responseSuccess([
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }
}
