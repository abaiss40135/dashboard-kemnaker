<?php


namespace App\Services;


use App\Repositories\Abstracts\KecamatanRepositoryAbstract;
use App\Repositories\KecamatanRepository;
use App\Services\Interfaces\KecamatanServiceInterface;

class KecamatanService implements KecamatanServiceInterface
{
    protected $kecamatanRepository;

    /**
     * KecamatanService constructor.
     * @param KecamatanRepositoryAbstract $kecamatanRepository
     */
    public function __construct()
    {
        $this->kecamatanRepository = new KecamatanRepository(app());
    }

    public function getSelectData()
    {
        return $this->kecamatanRepository
                    ->getFilterWithAllData(request()->all(), ['code', 'name'])
                    ->map(function ($item){
                        return [
                            'id' => $item['code'],
                            'text' => $item['name']
                        ];
                    });
    }

    public function getDistrictCodePoldaMetroJaya()
    {
        $kota_tangerang = [
            'BATUCEPER',
            'BENDA',
            'TANGERANG',
            'NEGLASARI',
            'CIPONDOH',
            'KARAWACI',
            'CILEDUG',
            'JATIUWUNG',
            'KARANG TENGAH',
            'LARANGAN',
            'CIBODAS',
            'PERIUK',
            'PINANG'
        ];

        $kab_tangerang = [
            'SEPATAN',
            'SEPATAN TIMUR',
            'TELUKNAGA',
            'PAKUHAJI',
            'KOSAMBI'
        ];

        $depok = [
            'SUKMAJAYA',
            'BOJONG GEDE',
            'TAJURHALANG',
            'CIMANGGIS',
            'TAPOS',
            'BEJI',
            'CILODONG',
            'CIPAYUNG',
            'PANCORAN MAS',
            'LIMO',
            'CINERE',
            'SAWANGAN',
            'BOJONGSARI'
        ];

        $tangerang_selatan = [
            'CIPUTAT',
            'CIPUTAT TIMUR',
            'PAMULANG',
            'PONDOK AREN',
            'SERPONG',
            'SERPONG UTARA',
            'CISAUK',
            'SETU',
            'CURUG',
            'KELAPA DUA',
            'LEGOK',
            'PAGEDANGAN'
        ];

        $bekasi_kota = [
            'BEKASI BARAT',
            'BEKASI SELATAN',
            'BEKASI TIMUR',
            'BEKASI UTARA',
            'PONDOKGEDE',
            'JATIASIH',
            'BANTARGEBANG',
            'MEDANSATRIA',
            'RAWALUMBU',
            'PONDOKMELATI',
            'JATISAMPURNA',
            'MUSTIKAJAYA'
        ];

        $kab_bekasi = [
            'TAMBUN UTARA',
            'TAMBUN SELATAN',
            'CIBITUNG',
            'KARANG BAHAGIA',
            'CIKARANG BARAT',
            'CIKARANG TIMUR',
            'CIKARANG PUSAT',
            'CIKARANG UTARA',
            'CIKARANG SELATAN',
            'SERANG BARU',
            'CIBARUSAH',
            'KEDUNG WARINGIN',
            'PEBAYURAN',
            'TAMBELANG',
            'SUKATANI',
            'TARUMAJAYA',
            'BABELAN',
            'CABANGBUNGIN',
            'MUARAGEMBONG',
            'BOJONGMANGU',
            'SUKAKARYA',
            'SUKAWANGI'
        ];

        return $this->kecamatanRepository->getQuery()
            ->whereIn('name', array_merge(
                $kota_tangerang, $kab_tangerang, $depok,
                $tangerang_selatan, $bekasi_kota, $kab_bekasi
            ))->pluck('code')->toArray();
    }

    public function getIdTambahanPoldaBanten()
    {
        return $this->kecamatanRepository
                    ->getQuery()
                    ->where('name', 'like', '%CISOKA')
                    ->orWhere('name', 'like', '%TIGARAKSA')
                    ->orWhere('name', 'like', '%CIKUPA')
                    ->orWhere('name', 'like', '%PANONGAN')
                    ->orWhere('name', 'like', '%BALARAJA')
                    ->orWhere('name', 'like', '%KRESEK')
                    ->orWhere('name', 'like', '%KRONJO')
                    ->orWhere('name', 'like', '%PASAR KEMIS')
                    ->orWhere('name', 'like', '%RAJEG')
                    ->orWhere('name', 'like', '%MAUK')
                    ->orWhere(function ($query){
                        $query->where('city_code', '3673')
                            ->where('name', 'CURUG');
                    })
                    ->pluck('code')
                    ->toArray();
    }
}
