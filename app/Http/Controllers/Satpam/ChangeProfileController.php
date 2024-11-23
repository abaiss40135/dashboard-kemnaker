<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\Bujp;
use App\Models\Provinsi;
use App\Models\Satpam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangeProfileController extends Controller
{
    private function addFile($file, $path)
    {
        $this->uploadPath = $path;

        return $this->saveFIles($file);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bujps = Bujp::pluck('nama_badan_usaha', 'id');
        $province = Provinsi::pluck('name', 'code');
        $data = Satpam::where('user_id', auth()->user()->id)->first();

        return view('satpam.profile', compact('data', 'province', 'bujps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'foto_kta' => 'required|mimes:png,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ubah-profile-satpam.index')->withErrors($validator);
        }

        $data = $request->except(['_method', '_token', 'suku', 'jenis_satpam', 'foto_kta']);
        $satpam = Satpam::where('id', $id)->first();

        if ($request->hasFile('foto_kta')) {
            $path = 'satpam/foto_kta/';
            $data['foto_kta'] = $this->addFile($request->file('foto_kta'), $path);
            if ($satpam->foto_kta) {
                $this->deleteFiles($satpam->foto_kta);
            }
        }

        $satpam->update($data);
        $this->flashSuccess('berhasil mengubah profile');

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
