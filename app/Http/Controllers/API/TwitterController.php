<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Atymic\Twitter\Facade\Twitter;

class TwitterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndonesiasTrends()
    {
        $woeid = 23424846;
        if (request()->has('polda')){
            $closestLocation = $this->getClosestTrends(Provinsi::where('polda', request()->get('polda'))->first())[0];
            if ($closestLocation->countryCode == 'ID'){
                $woeid = $closestLocation->woeid;
            }
        }
        return Twitter::getTrendsPlace(['id' => $woeid]);
    }

    public function getClosestTrends($province = null)
    {
        $coordinates = ['lat' => '-6.200000', 'long' => '106.816666'];
        if ($province){
            $coordinates = json_decode($province->meta, true);
        }
        return Twitter::getTrendsClosest($coordinates);
    }
}
