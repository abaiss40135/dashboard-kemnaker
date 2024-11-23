<?php

namespace App\Helpers;

use App\Models\Sipp\Satuan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApiHelper
{

    protected static function checkConnection(): bool
    {
        try {
            $response =  Http::post(config('app.sipp_full_api_url').'login', [
                'username' => config('sipp-api.username'),
                'password' => config('sipp-api.password'),
            ]);

            if ($response->successful()) {
                return true;
            }
        } catch (\Exception $exception){
            return false;
        }
    }

    public static function getToken()
    {
        $response = false;
        try {
            $response =  Http::retry(3, 60)->post(config('app.sipp_full_api_url').'login', [
                'username' => config('sipp-api.username'),
                'password' => config('sipp-api.password'),
            ]);
            if ($response->successful()){
                (new self)->setTokenInCookie($response);
                return $response['access_token'];
            }
        } catch (\Exception $exception){
            return response()->json([
                "status"    =>  "error",
                "message"   =>  !$response ? 'Mencoba kembali dalam 1 menit' : $response->toException()->getMessage(),
                "code"      =>  Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getPersonelByNrp($nrp)
    {
        try {
            $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'personel/nrp', [
                'nrp' => $nrp
            ]);
            if ($response->successful()){
                $data = $response['data']['personel'];
                if (!empty($response['data']['personel']['foto_file'])) {
                    try {
                        $image = file_get_contents($response['data']['personel']['foto_file']);
                        if ($image !== false) {
                            $data['foto'] = 'data:image/jpg;base64,' . base64_encode($image);
                        }
                    } catch (\Exception $exception) {
                        $data['foto'] = 'data:image/jpg;base64,' . file_get_contents(asset('img/default-compress.jpg'));
                    }
                }
                session(['personel' => $data]);
            }
            return $response->json();
        } catch (\Exception $exception){
            Log::error('SIPP API-'.$exception->getMessage(), $exception->getTrace());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getPersonelSingkatByNrp($nrp)
    {
        $token = self::getToken();
        try {
            $response = Http::withToken($token)->get(config('app.sipp_full_api_url').'personel/singkat', [
                'nrp' => $nrp,
                'bos' => true
            ]);
            if ($response->successful()){
                if (!empty($response->collect()['data'])){
                    $data = $response->collect()['data'];
                    $data['foto'] = Constants::PLACEHOLDER_IMG;
                    if (!empty($response['data']['foto_file'])){
                        try {
                            $image = file_get_contents($response['data']['foto_file']);
                            if ($image !== false){
                                $data['foto'] = 'data:image/jpg;base64,'.base64_encode($image);
                            }
                        } catch (\Exception $exception){

                        }
                    }
                    session(['personel' => $data]);

                    return $data;
                }
            }
            return $response->json();
        } catch (\Exception $exception){
            Log::error('getPersonelSingkatByNrp', $exception->getTrace());
        }
    }

    public static function getBhabinByNrp($nrp)
    {
        $token = self::getToken();
        $params = [
            'nrp' => $nrp,
            'bos' => true
        ];

        $response = Http::retry(3, 60)->withToken($token)->get(config('app.sipp_full_api_url').'personel/singkat', $params);

        if ($response->successful()){
            if (!empty($response->collect()['data'])){
                $data = $response->collect()['data'];
                $data['foto'] = Constants::PLACEHOLDER_IMG;
                if (roles(['operator_bhabinkamtibmas_polda'])){
                    if ($data['satuan1'] != auth()->user()->personel->satuan1){
                        return response()->json(['message' => 'Personel yang diakses di luar polda anda.'], Response::HTTP_FORBIDDEN);
                    }
                }
                if (roles(['operator_bhabinkamtibmas_polres'])){
                    if ($data['satuan2'] != auth()->user()->personel->satuan2){
                        return response()->json(['message' => 'Personel yang diakses di luar polres anda.'], Response::HTTP_FORBIDDEN);
                    }
                }
                if (roles(['operator_bhabinkamtibmas_polsek'])){
                    if ($data['satuan3'] != auth()->user()->personel->satuan3){
                        return response()->json(['message' => 'Personel yang diakses di luar polsek anda.'], Response::HTTP_FORBIDDEN);
                    }
                }
                if (!empty($response['data']['foto_file'])){
                    try {
                        $image = file_get_contents($response['data']['foto_file']);
                        if ($image !== false){
                            $data['foto'] = 'data:image/jpg;base64,'.base64_encode($image);
                        }
                    } catch (\Exception $exception){

                    }
                }
                return $data;
            }
        }
        if (empty($response->json())){
            return response()->json(['message' => 'Personel dengan nrp ' .$nrp. ' tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }
        return $response->json();
    }

    public static function getBhabinsByNrps(Collection $nrps)
    {
        $params = $nrps->mapWithKeys(function ($nrp, $key){
            return ["nrp[$key]" => $nrp];
        })->all();
        $params['ews'] = 'true';

        $response = Http::retry(3, 60)->withToken(self::getToken())->get(config('app.sipp_full_api_url').'personel/nrps?', $params);
        if(!isset($response['data'])) return [
            'nama' => 'tidak terdaftar di sipp',
            'foto_file' => asset('img/default-compress.jpg'),
            'pangkat' => 'tidak terdaftar di sipp',
            'satuan1' => 'tidak terdaftar di sipp-404'
        ];
        return $response['data'];
    }

    public static function getPersonelByAttribute(string $nrp, $attribute)
    {
        $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'personel/custom/' . $nrp, [
            'attribute[]' => $attribute,
        ]);
        if ($response->successful()) {
            return $response['data'];
        }
    }

    public static function getPersonelPhoto($nrp)
    {
        if (self::checkConnection()) {
            $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'personel/custom-nrp/', [
                'nrp' => $nrp,
                'attribute[]' => 'photo_url',
            ]);

            if ($response->failed() || $response->clientError() || $response->serverError()){
                return asset('images/icons/user.svg');
            }
            if ($response->successful()) {
                return $response->collect(['data'])['photo_url'];
            }
        }

        return asset('images/icons/user.svg');
    }

    public static function getAllSatuan()
    {
        $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'satuan/all', [
            'show_all' => true
        ]);
        $satuans = [];
        if ($response->successful()) {
            return self::loopPagination($satuans, $response);
        }
    }

    public static function satuan(string $kode_satuan)
    {
        $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'satuan/kodeSatuan/' . $kode_satuan);
        if ($response->successful()) {
            return $response['data'];
        }
    }

    public static function getChildSatuan($satuan_id, $polres = false)
    {
        $collected = collect();
        if (self::checkConnection()){
            $response = Http::withToken(self::getToken())->get(config('app.sipp_full_api_url').'satuan/' . $satuan_id);
            $satuan = array();
            if ($response->successful()) {
                $satuan     = self::loopPagination($satuan, $response);
                $collected  = collect($satuan)->flatten(2);
                if ($polres) {
                    $collected = $collected->filter(function ($value, $key) {
                        return Str::contains($value['nama_satuan'], 'POLRES');
                    });
                }
            }
        } else {
            $collected = Satuan::query()
                ->where('kode_satuan', 'ilike', "$satuan_id%")
                ->where('nama_satuan', 'ilike', '%POLRES%')
                ->select('kode_satuan', 'nama_satuan')->get();
        }
        return $collected->keyBy('kode_satuan')->all();
    }

    public static function getChildSatuanByKodeSatuan($kode_satuan, bool $polres = false)
    {
        return Cache::remember('SIPP_API_GET_CHILD_SATUAN_' . $kode_satuan . (int)$polres, defaultCacheTime(), function () use ($polres, $kode_satuan) {
            $satuanPolda = $kode_satuan;
            if (self::checkConnection()){
                $satuanPolda = self::satuan($kode_satuan)['satuan_id'] ?? '000';
            }
            return self::getChildSatuan($satuanPolda, $polres);
        });
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

    private static function loopPagination(array $data, $response)
    {
        $data[] = $response['data'];
        while ($response['meta']['current_page'] < $response['meta']['last_page']) {
            $response = Http::withToken(self::getToken())->get($response['links']['next']);
            if ($response->successful()) {
                $data[] = $response['data'];
            }
        }
        return $data;
    }
}
