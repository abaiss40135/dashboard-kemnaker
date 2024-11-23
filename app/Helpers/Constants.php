<?php

namespace App\Helpers;

class Constants
{
    // Max file upload size
    const MAX_FILE_SIZE = 50; //MB
    const MAX_FILE_SIZE_KB = 51200; //Kb
    const idMetroJaya = 31;
    const idBanten = 36;
    const host_cloud = 'https://is3.cloudhost.id/lab-bos-storage';
    const content_storage = 'https://bos.polri.go.id/bos-content/';
    const regExpContentStorage = '/https:\/\/bos.polri.go.id\/bos-content\//';

    //
    const CACHE1DAY     = '86400';
    const CACHE1HOUR    = '3600';
    const CACHE1MINUTE  = '60';

    const PLACEHOLDER_IMG = 'data:image/jpeg;base64,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';

    const DUMMY_PERSONEL = array(
        'nrp' => '12345678',
        'foto' => '/img/bhabin/user/karno2.svg',
        'nama' => 'Karno Nur Cahyo',
        'jabatan' => 'Kaliwungu',
        'keterangan_tambahan' => '',
        'lama_jabatan' => '0 Tahun 4 bulan 10 Hari',
        'pangkat' => 'BHABINKANTIBMAS',
        'handphone' => '08118228886',
        'tanggal_lahir' => '1996-05-02',
    );

    const STATUS_AUDIT = [
        0 => 'Dijadwalkan',
        1 => 'Lulus',
        2 => 'Tidak Lulus',
        3 => 'Belum Dijadwalkan',
    ];

    const MAP_PATH = [
        "ACEH" => "path01",
        "SUMATERA UTARA" => "path02",
        "SUMUT" => "path02",
        "SUMATERA BARAT" => "path03",
        "SUMBAR" => "path03",
        "RIAU" => "path04",
        "JAMBI" => "path05",
        "SUMATERA SELATAN" => "path06",
        "SUMSEL" => "path06",
        "BENGKULU" => "path07",
        "LAMPUNG" => "path08",
        "KEPULAUAN BANGKA BELITUNG" => "path09",
        "KEP. BABEL" => "path09",
        "KEPULAUAN RIAU" => "path10",
        "KEP. RIAU" => "path10",
        "KEPRI" => "path10",
        "DKI JAKARTA" => "path11",
        "METRO JAYA" => "path11",
        "JAWA BARAT" => "path12",
        "JABAR" => "path12",
        "JAWA TENGAH" => "path13",
        "JATENG" => "path13",
        "BANTEN" => "path14",
        "JAWA TIMUR" => "path15",
        "JATIM" => "path15",
        "YOGYAKARTA" => "path16",
        "DAERAH ISTIMEWA YOGYAKARTA" => "path16",
        "DIY" => "path16",
        "BALI" => "path17",
        "NUSA TENGGARA BARAT" => "path18",
        "NTB" => "path18",
        "NUSA TENGGARA TIMUR" => "path19",
        "NTT" => "path19",
        "KALIMANTAN BARAT" => "path20",
        "KALBAR" => "path20",
        "KALIMANTAN TENGAH" => "path21",
        "KALTENG" => "path21",
        "KALIMANTAN SELATAN" => "path22",
        "KALSEL" => "path22",
        "KALIMANTAN TIMUR" => "path23",
        "KALTIM" => "path23",
        "KALIMANTAN UTARA" => "path24",
        "KALTARA" => "path24",
        "SULAWESI UTARA" => "path25",
        "SULUT" => "path25",
        "SULAWESI TENGAH" => "path26",
        "SULTENG" => "path26",
        "SULAWESI SELATAN" => "path27",
        "SULSEL" => "path27",
        "SULAWESI TENGGARA" => "path28",
        "SULTRA" => "path28",
        "GORONTALO" => "path29",
        "SULAWESI BARAT" => "path30",
        "SULBAR" => "path30",
        "MALUKU" => "path31",
        "MALUKU UTARA" => "path32",
        "MALUT" => "path32",
        "PAPUA" => "path33",
        "PAPUA BARAT" => "path34"
    ];

    const OPERATOR_BHABINKAMTIBMAS = [
        'operator_bhabinkamtibmas_polda',
        'operator_bhabinkamtibmas_polres',
        'operator_bhabinkamtibmas_polsek'
    ];

    CONST OPERATOR_POLSUS = [
        'operator_polsus_polda',
        'operator_polsus_kl',
        'operator_polsus_kl_provinsi',
        'operator_polsus_kl_kota_kabupaten'
    ];
    const OPERATOR_BAGOPSNALEV = [
        'operator_bagopsnalev_mabes',
        'operator_bagopsnalev_polda',
        'operator_bagopsnalev_polres'
    ];

    const OPERATOR_BINPOLMAS=[
        'operator_binpolmas_polda',
        'operator_binpolmas_polres'
    ];


    const SCOPE_BHABINKAMTIBMAS = [
        'bhabinkamtibmas',
        'bhabinkamtibmas_mutasi',
        'bhabinkamtibmas_pensiun'
    ];

    const SCOPE_BINPOLMAS = [
        'operator_binpolmas_polres',
    ];

    const SCOPE_BAGOPSNALEV = [
        'operator_bagopsnalev_polres'
    ];

    const UPDATE_ROLE_AUTHORITY = [
        'polsek' => self::SCOPE_BHABINKAMTIBMAS,
        'polres' => [
            ...self::SCOPE_BHABINKAMTIBMAS,
            'operator_bhabinkamtibmas_polsek'
        ],
        'polda'  => [
            ...self::SCOPE_BHABINKAMTIBMAS,
            'operator_bhabinkamtibmas_polsek',
            'operator_bhabinkamtibmas_polres',
            'operator_bagopsnalev_polres',
            
            ... self::SCOPE_BAGOPSNALEV,
                'operator_bagopsnalev_polres',

            ... self::SCOPE_BINPOLMAS,
            'operator_binpolmas_polres'
        ],

        
    ];

    const SATUAN_PERSONEL_BY_LEVEL = [
        'polda' => 'satuan1',
        'polres' => 'satuan2',
        'polsek' => 'satuan3'
    ];

    
    CONST RUTINITAS_KURANG = "KURANG";

    CONST RUTINITAS_CUKUP = "CUKUP";

    CONST RUTINITAS_AKTIF = "AKTIF";

    CONST KLASTER_RUNITITAS = [
        self::RUTINITAS_KURANG, self::RUTINITAS_CUKUP, self::RUTINITAS_AKTIF
    ];
}
