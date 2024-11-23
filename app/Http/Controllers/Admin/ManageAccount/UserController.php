<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PengelolaanAkun\UpdateAccountRequest;
use App\Http\Requests\Administrator\PengelolaanAkun\User\ExportUserRequest;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getDatatable()
    {
        $this->checkPermission('pengelolaan_akun_access');
        return $this->userService->getDatatable();
    }

    public function export(ExportUserRequest $request, Excel $excel, UserExport $export)
    {
        return $excel->download($export, 'User ' . config('app.name') . ' ' . now() . '.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPermission('pengelolaan_akun_access');
        return view('administrator.pengelolaan-akun.daftar-akun');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        $this->checkPermission('pengelolaan_akun_show');
        return view('administrator.pengelolaan-akun.user.show', [
            'user' => $user,
            'hak_akses' => $user->roles->map(function ($item, $key) {
                return "<span class='text-md m-1 badge badge-primary w-75'>{$item->alias}</span>";
            }),
            'personel' => $user->personel
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->update($request->validated(), $id, $request->role_id != null ? [(int)$request->role_id] : []);
            DB::commit();
            return $this->responseSuccess([
                'data' => $user,
                'message' => 'Akun berhasil diperbarui'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseError($exception);
        }
    }

    public function getSelect2(Request $request)
    {
        return $this->userService->getSelectData();
    }
}
