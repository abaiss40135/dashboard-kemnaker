<?php

namespace App\Services\Sislap\Lapsubjar\Bintibsos;

use App\Models\Sislap\Lapsubjar\Bintibsos\DaiKamtibmas;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\SislapService;
use Illuminate\Http\Request;

class DaiKamtibmasAnggotaPolriService
{
    /**
     * @var SislapServiceInterface
     */
    private $sislapService;

    public $columns = [
        'polda',
        'polres',
        'nama',
        'gender',
        'pangkat',
        'nrp',
        'jabatan',
        'kesatuan',
        'no_suket_pelatihan',
        "tanggal_suket",
        "no_skep_pengangkatan",
        "tanggal_skep",
        "no_kta",
        "tanggal_kta",
        "provinsi",
        "kabupaten",
        "kecamatan",
        "kelurahan",
        "dusun",
        "rw",
        "rt",
        "alamat",
        "no_hp",
        'perorangan_kelompok',
    ];

    public $anggotaPolriColumns = [
        'pangkat',
        'nrp',
        'jabatan',
        'kesatuan',
    ];

    public $dateColumn = [
        'tanggal',
        'tanggal_suket',
        'tanggal_skep',
        'tanggal_kta'
    ];

    public $addressColumn = [
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
    ];

    public function __construct()
    {
        $this->sislapService = new SislapService();
    }

    public function search(Request $request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export($request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    protected function getQuery($request)
    {
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return DaiKamtibmas::query()->has('dataPolri')
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
                'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2',
                'dataPolri')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nama', 'ilike', '%'. $search .'%')
                        ->orWhere('gender', 'ilike', '%'.$search .'%')
                        ->orWhere('polda', 'ilike', '%'.$search .'%')
                        ->orWhere('polres', 'ilike', '%'.$search .'%')
                        ->orWhere('perorangan_kelompok', 'ilike', '%'.$search .'%')
                        ->orWhere('no_suket_pelatihan', 'ilike', '%'.$search .'%')
                        ->orWhere('tanggal_suket', 'ilike', '%'.$search .'%')
                        ->orWhere('no_skep_pengangkatan', 'ilike', '%'.$search .'%')
                        ->orWhere('tanggal_skep', 'ilike', '%'.$search .'%')
                        ->orWhere('no_kta', 'ilike', '%'.$search .'%')
                        ->orWhere('tanggal_kta', 'ilike', '%'.$search .'%')
                        ->orWhere('no_hp', 'ilike', '%'.$search .'%')
                        ->orWhere('alamat', 'ilike', '%'.$search .'%')
                        ->orWhere('provinsi', 'ilike', '%'.$search .'%')
                        ->orWhere('kabupaten', 'ilike', '%'.$search .'%')
                        ->orWhere('kecamatan', 'ilike', '%'.$search .'%')
                        ->orWhere('kelurahan', 'ilike', '%'.$search .'%')
                        ->orWhere('dusun', 'ilike', '%'.$search .'%')
                        ->orWhere('rw', 'ilike', '%'.$search .'%')
                        ->orWhere('rt', 'ilike', '%'.$search .'%')
                        ->orWhereHas('dataPolri', function ($q) use ($search) {
                            $q->where('pangkat', 'ilike', '%'.$search . '%')
                                ->orWhere('nrp', 'ilike', '%'.$search . '%')
                                ->orWhere('jabatan', 'ilike', '%'.$search . '%')
                                ->orWhere('kesatuan', 'ilike', '%'.$search . '%');
                        })
                        ->orWhereHas('personel', function ($q) use ($search) {
                            $q->where('satuan1', 'ilike', '%'.$search . '%')
                                ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                        });
                });
            })
            ->when($polda, function ($query) use ($polda) {
                return $query->join('personel', 'personel.user_id', '=', 'dai_kamtibmas.user_id')
                    ->where('personel.satuan1', 'ilike', $polda.'-%');
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->where('created_at', '>=', $start_date . ' 00:00:00');
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->where('created_at', '<=', $end_date . ' 23:59:59');
            });
    }
}
