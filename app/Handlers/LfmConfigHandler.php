<?php

namespace App\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        $personel = auth()->user()->personel;
        if (auth()->user()->haveRole('administrator')) {
            $folder = '';
        } elseif (auth()->user()->haveRole('operator_bagopsnalev_polda')) {
            $folder = $personel->polda;
        } elseif (auth()->user()->haveRole('operator_bagopsnalev_polres')) {
            $folder = $personel->polda . '/' . $personel->polres;
        } elseif (auth()->user()->haveRole('operator_bagopsnalev_polsek')) {
            $folder = $personel->polda . '/' . $personel->polres . '/' . $personel->polsek;
        } else {
            $folder = '';
        }
        return session('sislap_uri', '') . '/' . $folder;
    }
}
