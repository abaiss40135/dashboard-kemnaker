<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class LinkController extends Controller
{
    public function index()
    {
        $data = Link::all();
        return view('administrator.informasi-kamtibmas.link.index', compact('data'));
    }

    // create
    public function store(Request $request)
    {
        $request->validate([
            'nama_satker' => 'required',
            'link_satker' => 'required',
        ]);

        Link::create([
            'nama_satker' => $request->nama_satker,
            'link_satker' => $request->link_satker,
        ]);

        $this->flashSuccess('Berhasil menambahkan link satker');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_update_satker' => 'required',
            'link_update_satker' => 'required',
        ]);

        Link::where('id',$id)
            ->update([
            'nama_satker' => $request->nama_update_satker,
            'link_satker' => $request->link_update_satker,
        ]);

        $this->flashSuccess('Berhasil mengedit link satker');
        return back();
    }

    public function destroy($id) {
        Link::destroy($id);
        $this->flashSuccess('Berhasil menghapus link satker');
        return back();
    }
}
