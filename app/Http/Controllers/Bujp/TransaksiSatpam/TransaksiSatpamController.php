<?php

namespace App\Http\Controllers\Bujp\TransaksiSatpam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\StoreSatpamRequest;
use App\Models\Satpam;
use App\Models\Bujp;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransaksiSatpamController extends Controller
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
        $satpams = auth()->user()->bujp->satpams()->latest()->paginate(10);
        return view('bujp.transaksi-satpam.master-data-diri-satpam', compact('satpams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bujps = Bujp::where('user_id', auth()->user()->id)
            ->pluck('nama_badan_usaha', 'id');
        $province = Provinsi::pluck('name', 'code');
        $isFromBujp = true;
        return view('auth.register.satpam', compact('province', 'bujps', 'isFromBujp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreSatpamRequest $request)
    {
        $path = 'satpam/foto_kta/';

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->sync([7]);

            Satpam::create([
                'nama' => $request->nama,
                'no_ktp' => $request->no_ktp,
                'no_kta' => $request->no_kta,
                'jenis_kelamin' => $request->jenis_kelamin,
                'detail_alamat' => $request->detail_alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'no_hp' => $request->no_hp,
                'bujp_id' => $request->bujp_id,
                'tempat_tugas' => $request->tempat_tugas,
                'tanggal_terbit_kta' => $request->tanggal_terbit_kta,
                'foto_kta' => $this->addFile($request->file('foto_kta'),  $path),
                'user_id' => $user->id,
            ]);

            DB::commit();
            // jika berhasil redirect ke halaman sebelumnya
            $this->flashSuccess('Berhasil membuat akun');
            return redirect()->route('login');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
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
        $bujps = Bujp::where('user_id', auth()->user()->id)
            ->pluck('nama_badan_usaha', 'id');
        $province = Provinsi::pluck('name', 'id');
        $isFromBujp = true;
        $satpam = Satpam::where('id', $id)->first();
        return view('auth.update.satpam', compact('bujps', 'province', 'isFromBujp', 'satpam'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Satpam::destroy($id);
        $this->flashSuccess('Berhasil menghapus akun');
        return redirect()->route('transaksi-satpam.index');
    }
}
