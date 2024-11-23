<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Administrator\AtensiPimpinan\StoreAtensiPimpinanRequest;
use App\Http\Requests\Administrator\AtensiPimpinan\UpdateAtensiPimpinanRequest;
use App\Http\Controllers\Controller;
use App\Models\Personel;
use App\Services\Interfaces\AtensiPimpinanServiceInterface;
use Illuminate\Http\Request;

class AtensiPimpinanController extends Controller
{
    private $atensiPimpinanService;

    /**
     * AtensiPimpinanController constructor.
     * @param AtensiPimpinanServiceInterface $atensiPimpinanService
     */
    public function __construct(AtensiPimpinanServiceInterface $atensiPimpinanService)
    {
        $this->atensiPimpinanService = $atensiPimpinanService;
    }

    public function getSelectData()
    {
        if (request()->ajax()) {
            return $this->atensiPimpinanService->getSelectData();
        }
    }

    public function getDatatable()
    {
        return $this->atensiPimpinanService->getDatatable();
    }

    public function index()
    {
        $sasaran = request('sasaran') ?? request('role');
        if (request()->ajax()) {
            return $this->atensiPimpinanService->getFrontendData();
        }
        return view('administrator.atensi-pimpinan.index', ['sasaran' => $sasaran]);
    }

    public function create()
    {
        return view('administrator.atensi-pimpinan.create', ['sasaran' => request('sasaran', 'bhabinkamtibmas')]);
    }

    public function store(StoreAtensiPimpinanRequest $request)
    {
        try {
            $pemberi = Personel::find($request->pemberi);

            $this->atensiPimpinanService->store([
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'sasaran'       => $request->sasaran,
                'pemberi'       => $pemberi->jabatan . ' | ' . $pemberi->nama,
                'created_by'    => auth()->user()->id,
            ]);
            // redirect jika berhasil
            $this->flashSuccess('Berhasil Menambahkan Atensi Pimpinan');
            return redirect()->route('atensi-pimpinan.index', ['sasaran' => $request->sasaran]);
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // edit data atensi bhabin
    public function edit($id)
    {
        $data['atensi'] = $this->atensiPimpinanService->show($id);
        $data['sasaran'] = request('sasaran', 'bhabinkamtibmas');
        return view('administrator.atensi-pimpinan.edit', $data);
    }


    public function show($id) {
        // dd($id);
    }

    public function update(UpdateAtensiPimpinanRequest $request, $id)
    {
        try {
            $data = [
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'sasaran'       => $request->sasaran,
            ];
            if($request->pemberi) {
                $pemberi = Personel::find($request->pemberi);
                $data['pemberi'] = $pemberi->jabatan . ' | ' . $pemberi->nama;
            }

            $this->atensiPimpinanService->update($data, $id);
            $this->flashSuccess('Atensi Pimpinan berhasil diperbarui');
            return redirect()->route('atensi-pimpinan.index', ['sasaran' => $request->sasaran]);
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // hapus data
    public function destroy($id)
    {
        try {
            $this->atensiPimpinanService->delete($id);
            $this->flashSuccess("Berhasil Menghapus Atensi Pimpinan");
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
    }

    public function pemberiAtensi(Request $request)
    {
        return $this->atensiPimpinanService->getSelectPemberiAtensi($request->all());
    }
}
