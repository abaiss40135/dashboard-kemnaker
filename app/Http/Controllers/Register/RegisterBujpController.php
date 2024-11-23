<?php

namespace App\Http\Controllers\Register;

use App\Models\Bujp;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\StoreBUJPRequest;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterBujpController extends Controller
{
    public function __construct() {
        $this->province = Provinsi::pluck('name');
    }

    private function addFile($file, $path) {
        $this->uploadPath = $path;
        return $this->saveFiles($file);
    }

    private function deleteFile($id, $column) {
        $url = Bujp::where('id', $id)->pluck($column);
        $this->deleteFiles($url);
    }

    private function path($name, $column) {
        return 'bujp/' . strtolower(preg_replace('/\s/', '_', $name)) . '/' . $column;
    }

    public function index() {
        return view('auth.register.bujp', ['province' => $this->province]);
    }

    public function store(StoreBUJPRequest $request)
    {
        $data = $request->validated();
        unset($data['captcha']);

        $data['logo_badan_usaha'] = $this->addFile(
            $request->file('logo_badan_usaha'),
            $this->path($data['nama_badan_usaha'], 'logo')
        );
        $data['foto_penanggung_jawab'] = $this->addFile(
            $request->file('foto_penanggung_jawab'),
            $this->path($data['nama_badan_usaha'], 'foto_penanggung_jawab')
        );
        $data['foto_ktp_penanggung_jawab'] = $this->addFile(
            $request->file('foto_ktp_penanggung_jawab'),
            $this->path($data['nama_badan_usaha'], 'ktp_penanggung_jawab')
        );

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $data['email'],
                'password' => $data['password'],
            ]);
            $user->roles()->sync([6]);

            Bujp::create(array_merge(array_diff_key($data, array_flip(['email', 'password'])), ['user_id' => $user->id]));
            DB::commit();
            $this->flashSuccess('Selamat, akun anda berhasil dibuat');
            \Auth::loginUsingId($data['user_id']);
            return redirect()->intended();
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }

    }

    public function show($id) {
        //
    }

    public function edit($id) {

        $bujp = Bujp::find($id);
        if (auth()->user()->id !== $bujp->user_id){
            $this->flashWarning('Anda tidak diperkenankan mengakses bujp ini');
            return back();
        }
        return view('auth.update.bujp', ['province' => $this->province, 'bujp' => $bujp]);
    }

    public function update(Request $req, $id) {
        $data = $req->except([
            'bidang_usaha',
            'logo_badan_usaha',
            'foto_penanggung_jawab',
            'foto_ktp_penanggung_jawab',
            '_method',
            '_token',
            'email'
        ]);

        if ($req->file('logo_badan_usaha')) {
            $this->deleteFile($id, 'logo_badan_usaha');
            $data['logo_badan_usaha'] = $this->addFile(
                $req->file('logo_badan_usaha'),
                $this->path($req->nama_badan_usaha, 'logo')
            );
        }

        if ($req->file('foto_penanggung_jawab')) {
            $this->deleteFile($id, 'foto_penanggung_jawab');
            $data['foto_penanggung_jawab'] = $this->addFile(
                $req->file('foto_penanggung_jawab'),
                $this->path($req->nama_badan_usaha, 'foto_penanggung_jawab')
            );
        }

        if ($req->file('foto_ktp_penanggung_jawab')) {
            $this->deleteFile($id, 'foto_ktp_penanggung_jawab');
            $data['foto_ktp_penanggung_jawab'] = $this->addFile(
                $req->file('foto_ktp_penanggung_jawab'),
                $this->path($req->nama_badan_usaha, 'ktp_penanggung_jawab')
            );
        }

        if ($req->bidang_usaha) {
            $data['bidang_usaha'] = implode(',', $req->bidang_usaha) ?? $req->bidang_usaha;
        }

        Bujp::where('id', $id)->update($data);
        $this->flashSuccess('Berhasil Memperbarui Profil BUJP');
        return redirect()->route('home');
    }

    public function destroy($id) {
        //
    }
}
