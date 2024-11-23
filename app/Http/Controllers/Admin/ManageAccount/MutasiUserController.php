<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Http\Controllers\Controller;
use App\Models\MutasiUser;
use Illuminate\Http\Request;

class MutasiUserController extends Controller
{
    public function index()
    {
        $this->checkPermission('pengelolaan_akun_access');
        $query = MutasiUser::query()->with(['pengubah']);
        $query->when(request()->has('user_id'), function ($query) {
            $query->where('user_id', request('user_id'));
        });
        if (request()->ajax()) {
            //laravel datatable
            return datatables($query)
                ->editColumn('pengubah', function ($data) {
                    return $data->pengubah->getRole('alias')->alias;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->translatedFormat(config('app.long_datetime_format'));
                })
                ->addColumn('status', function ($data) {
                    //span class badge is approve or not
                    return is_null($data->is_approve) ? '<span class="badge badge-warning">Belum Disetujui</span>' :
                        ($data->is_approve == 1 ? '<span class="badge badge-success">Disetujui</span>' :
                            '<span class="badge badge-danger" data-toggle="popover" data-content="' . $data->note . '">Ditolak</span>');
                })
                ->addColumn('action', function ($data) {
                    /**
                     * if is_approve is null, show button approve and reject
                     * if is_approve is 1, show button reject
                     * if is_approve is 0, show button approve
                     */
                    return is_null($data->is_approve) ? '<div class="d-flex justify-content-between" style="column-gap: 5px;"><button type="button" class="btn btn-success btn-sm btn-approve" data-id="' . $data->id . '">Setujui</button>
                        <button type="button" class="btn btn-danger btn-sm btn-reject" data-id="' . $data->id . '">Tolak</button></div>' :
                        ($data->is_approve == 1 ? '<button type="button" class="btn btn-danger btn-sm btn-reject" data-id="' . $data->id . '">Tolak</button>' :
                            '<button type="button" class="btn btn-success btn-sm btn-approve" data-id="' . $data->id . '">Setujui</button>');
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(MutasiUser $mutasiUser)
    {
    }

    public function edit(MutasiUser $mutasiUser)
    {
    }

    public function update(Request $request, MutasiUser $mutasiUser)
    {
        $this->checkPermission('pengelolaan_akun_edit');
        try {
            $mutasiUser->update($request->all());
            if (request()->ajax()){
                return $this->responseSuccess(['message' => 'Berhasil mengubah data']);
            } else {
                $this->flashSuccess('Berhasil mengubah data');
                return back();
            }
        } catch (\Exception $e) {
            if (request()->ajax()){
                return $this->responseError($e);
            } else {
                $this->flashError($e->getMessage());
                return back();
            }
        }

    }

    public function destroy(MutasiUser $mutasiUser)
    {
    }
}
