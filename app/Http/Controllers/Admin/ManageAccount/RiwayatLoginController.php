<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class RiwayatLoginController extends Controller
{
    public function index()
    {
        $this->checkPermission('pengelolaan_akun_access');
        $query = LoginLog::query();
        $query->when(request()->has('user_id'), function ($query) {
            $query->where('user_id', request('user_id'));
        });
        if (request()->ajax()) {
            return datatables($query)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->translatedFormat(config('app.long_datetime_format'));
                })
                ->toJson();
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(LoginLog $riwayatLogin)
    {
    }

    public function edit(LoginLog $riwayatLogin)
    {
    }

    public function update(Request $request, LoginLog $riwayatLogin)
    {
    }

    public function destroy(LoginLog $riwayatLogin)
    {
    }
}
