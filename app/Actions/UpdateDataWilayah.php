<?php

namespace App\Actions;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Http;

class UpdateDataWilayah
{
    /**
     *
     */
    public function execute()
    {
        $repo = Http::get('https://gist.githubusercontent.com/codenoid/a2f06c0f23fdb99e2a8a247ecfc59c16/raw/8f9f38640151f38b33c57ef943497f83819970b8/wilayah.json');
        $datas = $repo->json();

        echo "The Beningging \n";
        foreach ($datas['provinsi'] as $cs => $ns) {
            $provinsi = Provinsi::firstOrCreate(['code' => $cs], [
                'name' => $ns
            ]);
            if ($provinsi->wasRecentlyCreated) {
                echo "Update $ns \n";
            }
        }

        foreach ($datas['kabupaten'] as $cs => $kabs) {
            foreach ($kabs as $ck => $nk) {
                $kodekab = $cs.$ck;
                $namakab = strpos($nk, "KOTA ") ? $nk : "KABUPATEN ". $nk;
                $kota = Kota::firstOrCreate([
                    'province_code' => $cs,
                    'code' => $kodekab
                ], [
                    'name' => $namakab
                ]);

                if ($kota->wasRecentlyCreated) {
                    echo "Update KAB/KOTA $namakab \n";
                }
            }
        }

        foreach ($datas['kecamatan'] as $ck => $kecamatans) {
            foreach ($kecamatans as $ckc => $nkc) {
                $kodekecamatan = $ck.$ckc;
                $kec = Kecamatan::firstOrCreate([
                    'city_code' => $ck,
                    'code' => $kodekecamatan
                ], [
                    'name' => $nkc
                ]);

                if ($kec->wasRecentlyCreated) {
                    echo "Update Kecamatan $nkc \n";
                }
            }
        }

        foreach ($datas['kelurahan'] as $ckc => $desas) {
            foreach ($desas as $cd => $nd) {
                $kodedesa = $ckc.$cd;
                $desa = Desa::firstOrCreate([
                    'district_code' => $ckc,
                    'code' => $kodedesa
                ], [
                    'name' => $nd
                ]);

                if ($desa->wasRecentlyCreated) {
                    echo "Update Desa $nd \n";
                }
            }
        }

        echo "Complete";
    }
}
