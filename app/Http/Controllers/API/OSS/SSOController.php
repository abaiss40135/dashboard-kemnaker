<?php

namespace App\Http\Controllers\API\OSS;

use App\Http\Controllers\Controller;
use App\Models\OSS\NIB;
use App\Models\User;
use App\Services\OSS\SSOService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SSOController extends Controller
{

    /**
     * @var mixed
     */
    private $accessToken;
    /**
     * @var mixed
66666     */
    private $url;

    public function __construct()
    {
        $this->url = app()->environment('production') ?
            config('oss-api.sso_prod_url') :
            config('oss-api.sso_dev_url');
    }


    public function receiveToken(Request $request, SSOService $SSOService)
    {
        if ($request->has('access-token')) {
            $this->accessToken = $request->get('access-token');

            //get user info
            $user_info = $this->userinfoToken();

            Log::info('SSO_OSSAPI', [
                'type' => 'receiveToken',
                'user_info' => $user_info
            ]);

            //handling expired
            if (!$user_info['data']) return $user_info;

            $nib = NIB::with('proyeks:id,nib_id,kbli', 'bujp.user:id,email')
                ->whereIn('nib', $user_info['data']['data_nib'])
                ->first();
            if ($validate = $SSOService->validate($nib)){
                if ($request->expectsJson()){
                    return response()->json($validate, Response::HTTP_OK);
                }
                abort($validate['status'], $validate['message']);
            };
            //check user by email
            if (empty($nib->bujp)) {
                $this->flashWarning('Mohon mendaftar terlebih dahulu');
                return redirect()->route('register-bujp.index')->with('nib', $nib->nib);
            }
            //login user with expired time
            Auth::login($nib->bujp->user);
            cookie('oss_access_token', $this->accessToken, config('session.lifetime'));
            return redirect()->route('transaksi.pendaftaran-sio.index');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $method = 'login';

        try {
            $response = Http::withBasicAuth(config('oss-api.username'), config('oss-api.client_secret'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'user_key' => config('oss-api.user_key')
                ])->post($this->url . $method, $request->all());
            if ($response->ok()){
                return $response->collect();
            }
        } catch (\Exception $exception) {

        }
    }

    public function validateToken()
    {
        $method = 'validate-token';
        try {
            $headers = [
                'user_key' => config('oss-api.user_key')
            ];
            $response = Http::withToken($this->accessToken)
                ->withHeaders($headers)
                ->post($this->url . $method);
            if ($response->ok()){
                return $response->collect();
            }
        } catch (\Exception $exception) {

        }
    }

    public function userinfoToken()
    {
        $method = 'userinfo-token';
        try {
            $headers = [
                'user_key' => config('oss-api.user_key')
            ];
            return Http::withToken($this->accessToken)
                ->withHeaders($headers)
                ->get($this->url . $method)->collect();
        } catch (\Exception $exception) {
            Log::error('Error userinfoToken: ' . $exception->getMessage());
        }
    }

    public function updateToken()
    {
        $method = 'update-token';
        try {
            $headers = [
                'user_key' => config('oss-api.user_key')
            ];
            $response = Http::withToken($this->refreshToken)
                ->withHeaders($headers)
                ->post($this->url . $method);
            if ($response->ok()){
                return $response->collect();
            }
        } catch (\Exception $exception) {

        }
    }

    public function revokeToken($accessToken)
    {
        $method = 'revoke-token';
        try {
            $headers = [
                'user_key' => config('oss-api.user_key')
            ];
            $response = Http::withToken($accessToken)
                ->withHeaders($headers)
                ->post($this->url . $method);
            if ($response->ok()){
                return $response->collect();
            }
        } catch (\Exception $exception) {

        }
    }
}
