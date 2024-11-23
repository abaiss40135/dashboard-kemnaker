<?php

namespace App\Http\Controllers\Laporan\Both;

use App\Events\VideoAdded;
use App\Http\Controllers\Controller;
use App\Models\VideoBoth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    private function addVideo($file){
        $this->uploadPath = 'bhabin/'. auth()->user()->nrp . '/laporan/both/video/'
                            . Carbon::now()->isoFormat('D-MMMM-Y');
        return $this->saveFiles($file);
    }

    private function deleteVideo(int|string $id) {
        if (is_numeric($id)) {
            $url = VideoBoth::where('id' , $id)->pluck('file');
            $this->deleteFiles($url);
        } else {
            $this->deleteFiles($id);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = VideoBoth::where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('bhabin.laporan.both.video.index', compact('data'));
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
     */
    public function store(Request $request)
    {
        $request->validate([
            'tambah.*' => 'required',
            'tambah.judul' => 'unique:video_boths,judul',
            'tambah.file' => 'required|mimes:mp4,3gp,webm,mkv,avi|max:51200'
        ], [
            'tambah.judul.unique' => 'Judul yang anda masukan sudah ada sebelumnya, mohon berikan judul yang unik!',
            'tambah.file.mimes' => 'File yang anda unggah bukan video!',
            'tambah.file.max' => 'Ukuran file yang anda unggah terlalu besar!'
        ]);

        $data = [
            'judul'   => $request->tambah['judul'],
            'caption' => $request->tambah['caption'],
            'file'    => $this->addVideo($request->tambah['file']),
            'penulis' => auth()->user()->personel->nama,
            'user_id' => auth()->user()->id
        ];

        try {
            $video = VideoBoth::create($data);

            event(new VideoAdded($video));
        } catch (\Throwable $th) {
            $this->deleteVideo($data['file']);
            $this->flashError('Gagal Menambahkan Video', $th->getMessage());
            return back();
        }

        $this->flashSuccess('Berhasil Menambahkan Video');
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
            'edit.file' => 'mimes:mp4,3gp,webm,mkv,avi'
        ]);

        $data = [
           'judul' => $request->edit['judul'],
           'caption' => $request->edit['caption'],
        ];

        if($request->file('edit.file')){
           $this->deleteVideo($id);
           $data['file'] = $this->addVideo($request->edit['file']);;
        }

        VideoBoth::where('id' , $id)->update($data);
        $this->flashSuccess('Berhasil memperbarui video');
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
        $this->deleteVideo($id);
        VideoBoth::destroy($id);

        $this->flashSuccess('Berhasil menghapus video');
        return back();
    }

    public function search(Request $request)
    {
        $data = VideoBoth::where('user_id', auth()->user()->id)
                ->where(function($query) use ($request) {
                    $query->where('judul', 'ilike', '%'.$request->cari.'%')
                    ->orWhere('caption', 'ilike', '%'.$request->cari.'%');
                })->latest()->paginate(10);

        return view('bhabin.laporan.both.video.index', compact('data'));
    }
}
