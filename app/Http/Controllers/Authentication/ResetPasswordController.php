<?php

namespace App\Http\Controllers\Authentication;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset(Request $request) {
        $request->validate([
            'email'        => 'required',
            'new_password' => 'required'
        ]);

        $user = User::where('email', strtolower($request->email))
                ->orWhere('nrp', $request->email)
                ->first();

        $has_error = empty($user) ? 'User tersebut tidak ditemukan' : null;
        $has_error = $has_error ?? $this->validateAuthority($user);
        if (!empty($has_error)) {
            $this->flashWarning($has_error);
            return back();
        }

        try {
            $user->update(['password' => bcrypt($request->new_password)]);
            $this->flashSuccess('Password berhasil diperbarui');

            return redirect()->route(auth()->user()->role());
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
    }

    private function validateAuthority(User $user) {
        $user_role     = $user->getRole('name')->name;
        $user_personel = $user->personel;
        $auth_user     = auth()->user();
        
        if ($user->id == $auth_user->id) return;
        
        if (!roles(['administrator', ...Constants::OPERATOR_BHABINKAMTIBMAS, ...Constants::OPERATOR_BAGOPSNALEV, ...Constants::OPERATOR_BINPOLMAS])) {
            return 'Anda tidak memiliki otoritas untuk mengubah password personel';
        }
        
        if (roles(Constants::OPERATOR_BHABINKAMTIBMAS)) {
            $auth_personel = $auth_user->personel;
            $auth_role     = $auth_user->getRole('name')->name;
            $auth_level    = substr(strrchr($auth_role, '_'), 1);
            $auth_satuan   = Constants::SATUAN_PERSONEL_BY_LEVEL[$auth_level];

            // if auth user is on level polda
            // check is user_personel->satuan1 == auth_personel->satuan1
            // for auth user on level polres, check satuan2 and polsek check satuan3
            if ($user_personel->{$auth_satuan} != $auth_personel->{$auth_satuan}) {
                return 'Perubahan dibatalkan, personel berada diluar satuan '.strtoupper($auth_level).' Anda';
            }

            // auth user can only change user whos in it authority
            if (!in_array($user_role, Constants::UPDATE_ROLE_AUTHORITY[$auth_level])) {
                return 'Perubahan dibatalkan, anda tidak diperkenankan mengubah password personel ini';
            }
        }
    }
}
