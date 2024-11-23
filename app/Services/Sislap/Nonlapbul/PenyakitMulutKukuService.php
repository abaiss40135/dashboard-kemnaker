<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\PenyakitMulutKuku;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class PenyakitMulutKukuService implements ExportInterface
{
    private $sislapService;

    public $kategori = [
        'hewan',
        'kandang',
        'terinfeksi',
        'mati',
        'potong',
        'sembuh',
        'vaksin',
    ];

    public $tipe = [
        'sapi',
        'kerbau',
        'kambing',
        'domba',
        'babi'
    ];
    public function __construct()
    {
        $this->sislapService = new SislapService();
    }

    public function search($request)
    {
        $query = $this->getQuery($request, true);

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export($request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    public function sumExport($collection)
    {
        $sums       = [];
        foreach ($this->kategori as $kategori) {
            foreach ($this->tipe as $jenis_hewan){
                $sums[$kategori.'_'.$jenis_hewan] = $collection->sum($kategori.'_'.$jenis_hewan);
            }
        }
        return $sums;
    }

    /**
     * @param $search
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function getQuery($request, $withApproval = null)
    {
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return PenyakitMulutKuku::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, function ($query) use ($search) {
            if (is_numeric($search)) {
                return $query->where('kandang_sapi', $search)
                    ->orWhere('kandang_kerbau'     , $search)
                    ->orWhere('kandang_kambing'    , $search)
                    ->orWhere('kandang_babi'       , $search)
                    ->orWhere('hewan_sapi'         , $search)
                    ->orWhere('hewan_kerbau'       , $search)
                    ->orWhere('hewan_kambing'      , $search)
                    ->orWhere('hewan_babi'         , $search)
                    ->orWhere('terinfeksi_sapi'    , $search)
                    ->orWhere('terinfeksi_kerbau'  , $search)
                    ->orWhere('terinfeksi_kambing' , $search)
                    ->orWhere('terinfeksi_babi'    , $search)
                    ->orWhere('vaksin_sapi'        , $search)
                    ->orWhere('vaksin_kerbau'      , $search)
                    ->orWhere('vaksin_kambing'     , $search)
                    ->orWhere('vaksin_babi'        , $search);
            }
            return $query->where('polres', 'ilike', "%$search%");
        })
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'penyakit_mulut_kukus.user_id')
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
