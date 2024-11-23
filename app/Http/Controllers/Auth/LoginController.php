<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Http\Controllers\API\OSS\SSOController;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Detection\MobileDetect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Sinergi\BrowserDetector\Browser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $username = strtolower(request()->input('username'));

        $fieldType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'nrp';

        request()->merge([$fieldType => $username]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts')
            && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            if ($user->doesntHaveRole() || ($user->mutasi->mutasi && $user->mutasi->is_approve)) {
                $this->guard()->logout();
                $this->sendNotPermittedResponse();
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function authenticated(Request $request, $user)
    {
        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->save();

        $detect = new MobileDetect();

        if ($detect->isAndroidOS()) {
            $platform = 'Android';
        } elseif ($detect->isiOS()) {
            $platform = 'iOS';
        } elseif ($detect->isWindowsPhoneOS()) {
            $platform = 'Windows Phone';
        } elseif ($detect->is('Windows')) {
            $platform = 'Windows';
        } elseif ($detect->is('Mac')) {
            $platform = 'Mac';
        } else {
            $platform = 'Unknown';
        }

        $browser = new Browser();

        LoginLog::create([
            'user_id' => $user->id,
            'platform' => $platform,
            'browser' => $browser->getName(),
            'ip_address' => $request->getClientIp(),
        ]);

        if (!empty($user->nrp)) {
            try {
                $personel = ApiHelper::getPersonelSingkatByNrp($user->nrp);
                if (!empty($personel)) {
                    $user->personel()->updateOrCreate([
                        'personel_id' => $personel['personel_id'],
                    ], [
                        'nama' => $personel['nama'],
                        'pangkat' => $personel['pangkat'],
                        'jabatan' => $personel['jabatan'],
                        'keterangan_tambahan' => $personel['keterangan_tambahan'],
                        'tmt_jabatan' => $personel['tmt_jabatan'],
                        'lama_jabatan' => $personel['lama_jabatan'],
                        'satuan' => $personel['satuan'],
                        'jenis_kelamin' => $personel['jenis_kelamin'],
                        'tanggal_lahir' => $personel['tanggal_lahir'],
                        'email' => $personel['email'],
                        'satuan1' => $personel['satuan1'],
                        'satuan2' => $personel['satuan2'],
                        'satuan3' => $personel['satuan3'],
                        'satuan4' => $personel['satuan4'],
                        'satuan5' => $personel['satuan5'],
                        'satuan6' => $personel['satuan6'],
                        'satuan7' => $personel['satuan7'],
                    ]);

                    if (empty($user->personel->handphone)) {
                        $user->personel->handphone = $personel['handphone'];
                        $user->personel->save();
                    }
                }

                session([
                    'personel' => array_merge(
                        [auth()->user()->personel],
                        ['foto' => $personel['foto']]
                    ),
                ]);
            } catch (\Exception $exception) {
                Log::alert("LOGIN {$exception->getMessage()}", $exception->getTrace());
            }
        } else {
            session(['personel' => Constants::DUMMY_PERSONEL]);
        }
    }

    protected function validateLogin(Request $request)
    {
        $username = $this->username();

        $request->validate([
            $username => ['required', 'string', "exists:users,{$username}"],
            'password' => ['required', 'string'],
            'captcha' => ['required',
                function ($attribute, $value, $fail) {
                    if ($value !== session()->get('captcha')) {
                        $fail('Kode angka tidak cocok.');
                    }
                },
            ],
        ], [
            "{$username}.required" => 'NRP atau email wajib diisi.',
            "{$username}.exists" => ucfirst($this->username).' tidak ditemukan',
            'password.required' => 'Password wajib diisi.',
        ]);
    }

    protected function sendNotPermittedResponse()
    {
        throw ValidationException::withMessages(['role' => 'Mohon maaf, Anda tidak memiliki otoritas untuk masuk.']);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($access_token = $request->cookie('oss_access_token')) {
            $sso = new SSOController();
            $sso->revokeToken($access_token);
        }

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
