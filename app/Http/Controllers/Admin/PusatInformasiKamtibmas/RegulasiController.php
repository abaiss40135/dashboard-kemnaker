<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Regulasi\StoreRegulasiRequest;
use App\Http\Requests\Administrator\PusatInformasi\Regulasi\UpdateRegulasiRequest;
use App\Services\Interfaces\RegulasiServiceInterface;
use Illuminate\Http\Request;

class RegulasiController extends Controller
{
    /**
     * @var RegulasiServiceInterface
     */
    private $regulasiService;

    public function __construct(RegulasiServiceInterface $regulasiService)
    {
        $this->regulasiService = $regulasiService;
    }

    public function getDatatable(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);
        return $this->regulasiService->getDatatable();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.regulasi.index');
    }

    public function create()
    {
        $header = request('type') == 'internal-polri' ? 'Peraturan di Dalam Lingkungan Polri' : (request('type') == 'eksternal-polri' ? 'Peraturan di Luar Lingkungan Polri' : 'Undang-Undang');
        return view('administrator.informasi-kamtibmas.regulasi.create', compact('header'));
    }

    public function store(StoreRegulasiRequest $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $this->regulasiService->store($request->validated());
            });
            return $this->responseSuccess([
                'message' => 'Data UU/Peraturan berhasil ditambahkan!'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    public function show($id)
    {
        return $this->regulasiService->show($id);
    }

    public function edit($type)
    {
        //
    }

    public function update(UpdateRegulasiRequest $request, $id)
    {
        try {
            \DB::transaction(function () use ($request, $id) {
                $this->regulasiService->update($request->validated(), $id);
            });
            return $this->responseSuccess([
                'message' => 'Data UU/Peraturan berhasil diperbarui!'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        return $this->regulasiService->delete($id);
    }
}
