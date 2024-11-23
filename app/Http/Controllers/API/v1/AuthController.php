<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function getToken()
    {
        $response =  Http::post(config('app.sipp_full_api_url').'login', [
            'username' => config('sipp-api.username'),
            'password' => config('sipp-api.password'),
        ]);
        $this->setTokenInCookie($response);
        return $response->json();
    }

 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function getPersonelByNrp($nrp)
    {
        $token = Cookie::get('api_token') ?? $this->getToken()['access_token'];
        $response = Http::withToken($token)->get(config('app.sipp_full_api_url').'personel/nrp', [
            'nrp' => $nrp
        ]);
        if ($response->ok()){
            session()->push('personel', $response['data']['personel']);
        }
        return $response->json();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function setTokenInCookie($data)
    {
        $arr_cookie_options = array (
            'expires' => strtotime('+' . $data['expires_in']),
            'path' => '/',
            'secure' => true,     // or false
            'samesite' => 'None' // None || Lax  || Strict
        );
        setcookie('api_token', $data['access_token'], $arr_cookie_options);
    }
}
