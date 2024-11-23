<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailChangeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class EmailChangeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Change Controller
    |--------------------------------------------------------------------------
    |
    | This controller allows the user to change his email address after he
    | verifies it through a message delivered to the new email address.
    | This uses a temporarily signed url to validate the email change.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only the authenticated user can change its email, but he should be able
        // to verify his email address using other device without having to be
        // authenticated. This happens a lot when they confirm by phone.
        $this->middleware('auth')->only('change');

        // A signed URL will prevent anyone except the User to change his email.
        $this->middleware('signed')->only('verify');
    }

    /**
     * Changes the user Email Address for a new one
     *
     * @param Request $request
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function change(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        // Send the email to the user
        Notification::route('mail', $request->email)
            ->notify(new EmailChangeNotification(Auth::user()->id));

        // Return the view/response
        if (request()->wantsJson()){
            return response()->json([
                'status' => 'success',
                'message' => 'Kami telah mengirimkan email untuk mengubah alamat email Anda. Silakan periksa kotak masuk atau spam Anda.'
            ]);
        }
        return back()->with([
            'email_changed' => $request->email
        ]);
    }

    /**
     * Verifies and completes the Email change
     *
     * @param Request $request
     * @param User $user
     * @param string $email
     * @return RedirectResponse
     */
    public function verify(Request $request, User $user, string $email)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        $request->merge(['email' => $email])->validate([
            'email' => 'required|email|unique:users'
        ]);
        // Change the Email
        DB::transaction(function () use ($request, $user) {
            $old_email = $user->email;
            $new_email = $request->email;
            $user->update([
                'email' => $new_email,
                'email_verified_at' => now()
            ]);
            $user->emailChanges()->create([
                'old_email' => $old_email,
                'new_email' => $new_email
            ]);
        });

        // And finally return the view telling the change has been done
        $this->flashSuccess('Email Anda berhasil diubah.');
        return redirect()->route(auth()->user()->role());
    }
}
