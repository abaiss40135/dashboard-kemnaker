<?php

namespace App\Http\Controllers\Laporan\Both;

use App\Http\Controllers\Controller;
use App\Models\MemeBoth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{

    private function addFile($file) {

        $this->uploadPath = 'bhabin/' .
                            auth()->user()->personel->nama . '/laporan/both/meme/' .
                            Carbon::now()->isoFormat('dddd , D MMMM Y');

        return $this->saveFiles($file);

    }

    private function deleteFile($id){
        $url = MemeBoth::where('id' , $id)->pluck('file');
        $this->deleteFiles($url);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $host_cloud = $this->host;
        $data = MemeBoth::where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('bhabin.laporan.both.meme.index', compact('data' , 'host_cloud'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'tambah.*' => 'required',
            'tambah.file' => 'mimes:jpg,jpeg,png'
        ]);



        $data = [
            'judul'   => $request->tambah['judul'],
            'caption' => $request->tambah['caption'],
            'file'    => $this->addFile($request->tambah['file']),
            'penulis' => auth()->user()->personel->nama,
            'user_id' => auth()->user()->id
        ];

        MemeBoth::create($data);

        $this->flashSuccess('Berhasil menambahkan meme');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit.judul' => 'required',
            'edit.caption' => 'required',
        ]);

       $data = [
           'judul' => $request->edit['judul'],
           'caption' => $request->edit['caption'],
       ];

       if($request->file('edit.file')){

           $this->deleteFile($id);
           $data['file'] =  $this->addFile($request->edit['file']);
       }

       MemeBoth::where('id' , $id)->update($data);

       $this->flashSuccess("Berhasil memperbarui meme");
       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteFile($id);
        MemeBoth::destroy($id);

        $this->flashSuccess('Berhasil menghapus meme');
        return back();
    }
}
