<?php

return [
    'name' => 'BosPWA',
    'manifest' => [
        'name' => config('app.name') .' - '. env('APP_LONG_NAME', 'My PWA App'),
        'short_name' => config('app.name'),
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'prefer_related_applications' => false,
        'lang' => 'Indonesian',
        'scope' => '/',
        'orientation'=> 'portrait-primary',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'maskable'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'maskable'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'maskable'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'maskable'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'purpose' => 'maskable'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'purpose' => 'maskable'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
          /*  [
                'name' => 'Pusat Informasi',
                'description' => 'Pusat Informasi Polri untuk masyarakat',
                'url' => '/pusat-informasi',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],*/
            [
                'name' => 'Baca Informasi Kamtibmas',
                'description' => 'Pusat Informasi Polri untuk masyarakat',
                'url' => '/pusat-informasi'
            ],
            [
                'name' => 'Laporkan Kejadian',
                'description' => 'Laporan kejadian',
                'url' => '/laporan'
            ],
            [
                'name' => 'Halo Bhabinkamtibmas',
                'description' => 'Cari dan hubungi anggota bhabinkamtibmas di sekitar anda',
                'url' => '/halo-bhabin'
            ]
        ],
        'custom' => []
    ]
];
