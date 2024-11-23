<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPicture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FileUploadTrait;

class SliderPictureController extends Controller
{
    private $url;

    private function addFile($file){
        $this->uploadPath = 'foto_slider';
        return $this->saveFiles($file);
    }

    private function unlinkFile($id){
        $file = LandingPicture::where('id' , $id)->pluck('file');
        $this->deleteFiles($file);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LandingPicture::orderBy('id')->get();
        return view('administrator.slider.gambar' , compact('data'));
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
        $this->checkPermission('foto_bhabinkamtibmas_create');
        $data['file'] = $this->addFile($request->file('file'));

        LandingPicture::create($data);

        $this->flashSuccess("Berhasil Menambahkan");
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
        $this->checkPermission('foto_bhabinkamtibmas_edit');
        $this->unlinkFile($id);

        $data['file'] = $this->addFile($request->edit['file']);
        LandingPicture::where('id' , $id)->update($data);
        $this->flashSuccess('Berhasil Mengupdate gambar');
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
        $this->checkPermission('foto_bhabinkamtibmas_destroy');
        $this->unlinkFile($id);
        LandingPicture::destroy($id);

        $this->flashSuccess('Berhasil Menghapus');
        return back();
    }
}
