<?php

namespace App\Http\Controllers\Laporan\LaporanKegiatan;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanKegiatan\Kreatifitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KreatifitasController extends Controller {
    private function addFile($file) {
        $this->uploadPath = 'bhabin/' . auth()->user()->nrp .
            '/laporan/laporan-kegiatan/kreatifitas' .
            Carbon::now()->isoFormat('dddd_D_MMMM_Y');
        return $this->saveFiles($file);
    }

    private function deleteFile($id) {
        $url = Kreatifitas::where('id' , $id)->pluck('file');
        $this->deleteFiles($url);
    }

    public function index() {
        $data = Kreatifitas::where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('bhabin.laporan.laporan-kegiatan.kreatifitas.index', compact('data'));
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required|unique:kreatifitas,judul',
            'pic' => 'required',
            'file' => 'required|mimes:mp4,3gp,webm,mkv|max:20480'
        ], [
            'judul.unique' => 'Judul yang anda masukan sudah ada sebelumnya, mohon berikan judul yang unik!',
            'file.mimes' => 'File yang anda unggah bukan video!',
            'file.max' => 'Ukuran file yang anda unggah terlalu besar!'
        ]);


        try {
            $data = [
                'judul'   => $request->judul,
                'pic' => $request->pic,
                'file'    => $this->addFile($request->file),
                'nama_bhabin' => auth()->user()->personel->nama,
                'user_id' => auth()->user()->id
            ];
            Kreatifitas::create($data);
            $this->flashSuccess('Berhasil Menambahkan Terbosan Kreatif dan Inovatif');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return back();
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $request->validate([
            'judul' => 'required',
            'pic' => 'required',
        ]);

        if ($request->file('file')) {
            // jika ada request berupa file, hapus yang lama, ganti yang baru
            $this->deleteFile($id);
            Kreatifitas::where('id', $id)->update([
                'file' => $this->addFile($request->file)
            ]);
        }

        Kreatifitas::where('id', $id)->update([
            'judul' => $request->judul,
            'pic' => $request->pic
        ]);

        $this->flashSuccess('Berhasil mengupdate Terbosan Kreatif dan Inovatif');
        return back();
    }

    public function destroy($id) {
        $this->deleteFile($id);

        Kreatifitas::destroy($id);
        $this->flashSuccess('Berhasil Menghapus Terbosan Kreatif dan Inovatif');
        return back();
    }
}
