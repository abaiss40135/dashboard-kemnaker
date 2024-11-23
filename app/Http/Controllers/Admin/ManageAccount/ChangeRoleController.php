<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\MutasiUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeRoleController extends Controller
{
    const MIN_AGE_TO_RETIRE = 58;

    public function index()
    {
        return view('administrator.pengelolaan-akun.ubah-role');
    }

    public function store(Request $request)
    {
        $this->checkPermission('pengelolaan_akun_edit');
        if (!roles([...Constants::OPERATOR_BHABINKAMTIBMAS, ...Constants::OPERATOR_BAGOPSNALEV, ...Constants::OPERATOR_BINPOLMAS, 'administrator'])) {
            abort(403);
        }

        $request->validate([
            'nrp' => 'required',
            'role' => 'nullable|array',
            'role.*' => 'nullable|exists:roles,id',
            'desc' => 'required|max:200',
            'mutasi' => 'nullable',
        ], [
            'nrp.required' => 'NRP harus diisi',
            'role.*.exists' => 'Role tidak ditemukan',
            'desc.required' => 'Deskripsi harus diisi',
            'desc.max' => 'Deskripsi maksimal 200 karakter',
        ]);

        $request_user = User::with('personel')
            ->where('email', $request->nrp)
            ->orWhere('nrp', $request->nrp)
            ->first();

        $request_role = $request->role ?? [];

        $has_error = $has_error ?? $this->validateRoleChange($request_user, $request_role);

        if (!empty($has_error)) {
            $this->flashWarning($has_error);
            return back();
        }

        try {
            $data = $this->prepareData($request_user, $request, $request_role);

            DB::transaction(function () use ($request_user, $data, $request_role) {
                MutasiUser::create($data + [
                    'is_approve' => true,
                ]);

                if (!empty($request_role)) $request_user->roles()->sync($request_role);
            });

            $this->flashSuccess('Berhasil memperbarui hak akses');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return back();
    }

    private function validateRoleChange(?User $request_user, array $request_role): ?string {
        $err_msg = "Perubahan dibatalkan, anda tidak diperkenankan mengubah hak akses";

        if (empty($request_user)) return "{$err_msg}, User tersebut tidak ditemukan";

        $request_user_role = $request_user->getRole("name")?->name;
        $request_user_personel = $request_user->personel;
        $user = auth()->user();

        $themself = $request_user->id == $user->id;
        if ($themself) return "{$err_msg} diri anda sendiri";

        $is_admin = $request_user_role == "administrator";
        if ($is_admin) return "{$err_msg} administrator";

        if (roles(Constants::OPERATOR_BHABINKAMTIBMAS, Constants::OPERATOR_BAGOPSNALEV, Constants::OPERATOR_BINPOLMAS)) {
            $personel = $user->personel;
            $role = $user->getRole("name")->name;
            $level = substr(strrchr($role, "_"), 1);
            $unit = Constants::SATUAN_PERSONEL_BY_LEVEL[$level];

            $outside_unit = $request_user_personel->{$unit} != $personel->{$unit};
            if ($outside_unit) return "{$err_msg}, personel di luar $level anda";

            $outside_authority = !in_array($request_user_role, Constants::UPDATE_ROLE_AUTHORITY[$level]);
            if ($outside_authority) return "{$err_msg} personel ini";
        }

        if (isset($request_role) && in_array(User::BHABINKAMTIBMAS_PENSIUN, $request_role)) {
            $birth = (int)str_split((string)$request_user->nrp, 2)[0];
            $year = (int)date("y");
            $age = $birth > $year ? $year + 100 - $birth : $year - $birth;

            $not_retire_yet = $age < self::MIN_AGE_TO_RETIRE;
            if ($not_retire_yet) return "{$err_msg}, personel belum memasuki usia pensiun";
        }

        return null;
    }

    private function prepareData(User $request_user, Request $request, array $request_role): array {
        $data = array_merge($request->except(['_token', 'role']), [
            'user_id' => $request_user->id,
            'user_id_pengubah' => auth()->user()->id
        ]);

        $data['mutasi'] = empty($data['mutasi']) ? false : true;

        $former_role = implode(', ', $request_user->roles->pluck('id')->toArray()) ?: 'null';
        $later_role = implode(', ', $request_role) ?: 'tidak berubah';
        $change_role = "[{$former_role} => {$later_role}]";

        $data['desc'] = "{$change_role} {$data['desc']}";

        return $data;
    }
}
