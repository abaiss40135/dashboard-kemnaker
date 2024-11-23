<?php

namespace App\Http\Controllers\Laporan\Both;

use App\Http\Controllers\Controller;
use App\Models\LinkBoth;
use Illuminate\Http\Request;

class LinkBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LinkBoth::where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('bhabin.laporan.both.link.index' , compact('data'));
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
        $data['judul'] = $request->tambah_judul;
        $data['link'] = $request->tambah_link;
        $data['penulis'] = auth()->user()->personel->nama;
        $data['user_id'] = auth()->user()->id;
        LinkBoth::create($data);

        $this->flashSuccess('Berhasil menambahkan link berita');
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
        $data['judul'] = $request->edit_judul;
        $data['link'] = $request->edit_link;
        LinkBoth::where('id' , $id)->update($data);

        $this->flashSuccess('Berhasil memperbarui link berita');
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
        LinkBoth::destroy($id);

        $this->flashSuccess('Berhasil menghapus link');
        return back();
    }
}
