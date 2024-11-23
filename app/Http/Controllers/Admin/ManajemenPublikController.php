<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenggunaPublik;
use App\Models\User;
use Illuminate\Http\Request;

class ManajemenPublikController extends Controller {
    public function index() {
        $this->checkPermission('manajemen_publik_access');
        return view('administrator.manajemen-publik.index');
    }

    public function search(Request $request)
    {
        $collection = PenggunaPublik::when($request->search, function ($query) use ($request) {
                return $query->where('nama', 'ilike', '%' . $request->search . '%')
                             ->orWhere('alamat', 'ilike', '%' . $request->search . '%')
                             ->orWhere('pekerjaan', 'ilike', '%' . $request->search . '%')
                             ->orWhere('alamat', 'ilike', '%' . $request->search . '%')
                             ->orWhere('lokasi_bekerja', 'ilike', '%' . $request->search . '%');
            })->when($request->type, function ($query) use ($request) {
                return $query->where('type', $request->type);
            })->orderByDesc('created_at')->paginate(10, ['*'], 'page');

        return response()->json($collection);
    }

    public function destroy($id)
    {
        $publikProfile = PenggunaPublik::find($id);
        $user_id = $publikProfile->user_id;

        $publikProfile->delete();
        User::find($user_id)->delete();
        return redirect()->back();
    }
}
