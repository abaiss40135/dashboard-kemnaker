<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KategoriInformasiSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            [
                'name'          => 'Narkoba',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-Narkoba.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-Narkoba.svg',
                'description'   => 'Narkotika, psikotropika, dan obat terlarang',
                'query'         => 'narkoba'
            ],
            [
                'name'          => 'Kenakalan Remaja',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-Kenakalan Remaja.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-Kenakalan Remaja.svg',
                'description'   => '-',
                'query'         => 'kenakalan remaja'
            ],
            [
                'name'          => 'Intoleransi, radikalisme, terorisme',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-Intoleransi, radikalisme, terorisme.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-Intoleransi, radikalisme, terorisme.svg',
                'description'   => '-',
                'query'         => 'intoleransi radikalisme terorisme'
            ],
            [
                'name'          => 'Covid19',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-covid19.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-covid19.svg',
                'description'   => '-',
                'query'         => 'covid19'
            ],
            [
                'name'          => 'Pelecehan Seksual',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-pelecehan-seksual.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-pelecehan-seksual.svg',
                'description'   => '-',
                'query'         => 'pelecehan seksual'
            ],
            [
                'name'          => 'Permasalahan Pinjaman Online',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-permasalahan-pinjaman-online.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-permasalahan-pinjaman-online.svg',
                'description'   => '-',
                'query'         => 'pinjaman online'
            ],
            [
                'name'          => 'TPPO',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-tppo.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-tppo.svg',
                'description'   => '-',
                'query'         => 'tppo'
            ],
            [
                'name'          => 'Informasi kegiatan desa dan kelurahan',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-informasi-kegiatan-desa-dan-kelurahan.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-informasi-kegiatan-desa-dan-kelurahan.svg',
                'description'   => '-',
                'query'         => 'kegiatan desa dan kelurahan'
            ],
            [
                'name'          => 'Informasi Pertanian',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-informasi-pertanian.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-informasi-pertanian.svg',
                'description'   => '-',
                'query'         => 'pertanian'
            ],
            [
                'name'          => 'Informasi Perkebunan',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-informasi-perkebunan.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-informasi-perkebunan.svg',
                'description'   => '-',
                'query'         => 'perkebunan'
            ],
            [
                'name'          => 'Informasi Peternakan',
                'icon_primary'  => 'assets/kategori-informasi/icon-primary-informasi-peternakan.svg',
                'icon_secondary'=> 'assets/kategori-informasi/icon-secondary-informasi-peternakan.svg',
                'description'   => '-',
                'query'         => 'peternakan'
            ],
        ];
        foreach ($kategori as $item) {
            \App\Models\KategoriInformasi::create($item);
        }
    }
}
