<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\StorePenggunaPublikRequest;
use App\Models\PenggunaPublik;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterPublikController extends Controller
{
    // form register publik
    public function index() {
        return view('auth.register.publik');
    }

    public function store(StorePenggunaPublikRequest $request)
    {
        $data = $request->validated();
        unset($data['captcha']);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
            ]);

            $user->roles()->sync([8]);

            PenggunaPublik::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'type' => $request->type,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
                'lokasi_bekerja' => $request->lokasi_bekerja,
            ]);

            DB::commit();
            // jika berhasil redirect ke halaman sebelumnya
            $this->flashSuccess('Berhasil membuat akun');
            return redirect()->route('login');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }
}
