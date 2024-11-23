<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\StoreSatpamRequest;
use App\Models\Provinsi;
use App\Models\Satpam;
use App\Models\User;
use App\Models\Bujp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterSatpamController extends Controller
{
    public function index() {
        return view('auth.register.satpam', [
            'province'   => Provinsi::pluck('name', 'code'),
            'bujps'      => Bujp::pluck('nama_badan_usaha', 'id'),
            'isFromBujp' => false
        ]);
    }

    public function store(StoreSatpamRequest $request)
    {
        $this->uploadPath = 'satpam';
        $this->folderName = 'foto_kta';
        $this->fileName   = 'kta-satpam-'.Str::slug($request->no_ktp).'.'.$request->file('foto_kta')->getClientOriginalExtension();
        $data = $request->validated();
        $data['foto_kta'] = $this->saveFiles($request->file('foto_kta'));
        unset($data['captcha']);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => strtolower($data['email']),
                'password' => bcrypt($data['password']),
            ]);
            $user->roles()->sync([7]);

            Satpam::create(array_merge(array_diff_key($data, array_flip(['email', 'password'])), ['user_id' => $user->id]));
            DB::commit();
            $this->flashSuccess('Berhasil membuat akun');
            return redirect()->route('login');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }
}
