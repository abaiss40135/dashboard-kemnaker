
A monolith application (currently) for reporting and information center for police in the sub-directorate of Binmas, including security guards and security service company permit management.

## requirement

- php 8.1
- composer
- openvpn
- npm
- git
- github account
- permission access to `https://github.com/adityapryg/bos`

## starting development

- run `git clone https://github.com/adityapryg/bos` to clone repository
- move to directory bos `mv bos`.
- run `composer install` to install php dependencies.
- (optional) run `composer dump-autoload -o` to optimizes PSR0 and PSR4 packages to be loaded with classmaps too, good for production.
- run `npm install` to install javascript dependencies.
- run `npm run dev` or `npm run prod` to generate required js & scss
- ask other developer for .env file & .ovpn file
- (optional) run `php artisan optimize` to clear config, cache, routes etc.
- run the application `php artisan serve`

## Running test

- php artisan test

## CI/CID

- this repo would automatically deploy to several web app using github action runner self-hosted

## Sislap

Part of BOSv2 application, focus on reporting.

### sislap structure

```bash
├── lapbul
│   ├── operasional
│   │   ├── (not available yet) format 4-1
│   │   ├── format-4-7 (data-kerjasama-ditbinmas)
│   │   └── format-4-8 (komunitas-binaan)
│   └── pembinaan
│       ├── format-4-11 (realisasi-anggaran)
│       ├── format-4-15 (personel-korbinmas)
│       ├── (not available yet) format-4-20
│       └── (not available yet) format-4-21
├── lapsubjar
│   ├── bagrenmin
│   │   ├── capaian-kinerja
│   │   └── serapan-anggaran
│   ├── bhabin
│   │   ├── rekap-kegiatan
│   │   ├── rekap-penggelaran
│   │   ├── rekap-penghargaan
│   │   └── rekap-perlengkapan
│   ├── binanevpolsus
│   │   ├── data-diklat-polsus
│   │   ├── data-giat-korwas
│   │   ├── data-katpuan-polsus
│   │   ├── data-kejadian
│   │   ├── data-kerjasama
│   │   ├── data-polsus-kl
│   │   └── data-senpi
│   ├── binkamsa
│   │   ├── data-bujp
│   │   ├── data-ijazah-satpam
│   │   ├── data-satkamling
│   │   ├── data-stok-opname
│   │   ├── hasil-pelaksanaan
│   │   ├── kasus-satpam
│   │   ├── pagelaran-satpam
│   │   ├── pelaksanaan-diklat
│   │   ├── prestasi-satpam
│   │   └── tindak-pidana-satpam
│   ├── binpolmas
│   │   ├── data-dai
│   │   ├── data-fkpm
│   │   ├── data-kommas
│   │   ├── data-ormas
│   │   ├── data-pokdarkamtibmas
│   │   ├── data-senkom
│   │   ├── kbpp-polri
│   │   └── kommas-kbpp
│   ├── bintibsos
│   │   ├── data-jumlah-anggota
│   │   ├── giat-linsek
│   │   ├── giat-pembinaan
│   │   ├── kegiatan-subditbintibsos
│   │   ├── saka-bhayangkara
│   │   └── upaya-preemtif
│   └── komsatpam
│       ├── data-assesor
│       └── data-satpam
└── nonlapbul
    ├── laphar-karhutla
    ├── laphar-pc
    ├── laphar-vaksinasi
    └── laporan3t
        ├── laphar-tracing
        ├── (not available yet) laphar-testing
        └── (not available yet) laphar-treatment
```
