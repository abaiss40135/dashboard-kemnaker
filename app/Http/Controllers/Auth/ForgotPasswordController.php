<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OSS\NIB;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $email = $request->get('email');
        //if numeric
        if (preg_match("/^\d+$/", $email)) {
            if (strlen($email) === 8) {
                /**
                 * Input NRP, cari email dari personel atau user
                 */
                $user = User::query()
                    ->where('nrp', $email)
                    ->with('personel:user_id,email,email_dinas')->first();
                if (!$user){
                    throw ValidationException::withMessages([
                        'email' => __('passwords.user_nrp')
                    ]);
                }
                $email = $user->personel->email ?? $user->personel->email_dinas ?? $user->email;
                /**
                 * Update email dari data personel, apabila berbeda update email user dengan email dari personel
                 */
                if ($user->email !== $email){
                    $user->update(compact('email'));
                }
            } else if (strlen($email) === 13) {
                /**
                 * Input NIB,, cari data NIB dan dapatkan email untuk mencari user berdasarkan nib
                 */
                $nib = NIB::where('nib', $email)->first();
                if ($nib) {
                    $email = $nib->email_perusahaan === '-' ? $nib->email_user_proses : $nib->email_perusahaan;
                    $user = User::where('email', $email)->first();
                    if (!$user) {
                        throw ValidationException::withMessages([
                            'email' => __('passwords.user_nib')
                        ]);
                    }
                } else {
                    throw ValidationException::withMessages([
                        'email' => __('passwords.user_nib')
                    ]);
                }
            }
        }

        $validator = Validator::make(['email' => $email],[
            'email' => 'required|email'
        ]);
        return $validator->safe()->only(['email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        $additionalMessage = Str::mask($this->credentials($request)['email'], '*', -15, 3) . ' yang berisi tautan untuk mereset kata sandi anda!';
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response) . $additionalMessage], 200)
            : back()->with('status', trans($response) . $additionalMessage);
    }
}
