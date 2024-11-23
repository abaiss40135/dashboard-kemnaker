<?php

namespace App\Services\Sislap\Lapsubjar\Binkamsa;

use App\Models\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class MasterDataSatpamBelumDikService implements ExportInterface
{
    private $sislapService;

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

    public function count($request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->countQueryByRole($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    protected function getQuery($request, $withApproval = null)
    {
        $search = $request->search;
        $polda = $request->polda;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return MasterDataSatpamBelumDik::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, fn ($q) => $q->where('no_reg', 'ilike', "%$search%")
            ->orWhere('nama', 'ilike', "%$search%")
            ->orWhere('perusahaan', 'ilike', "%$search%")
            ->orWhere('tanggal_lahir', 'ilike', "%$search%")
            ->orWhere('jenis_kelamin', 'ilike', "%$search%")
            ->orWhere('lama_bertugas', 'ilike', "%$search%")
            ->orWhere('dikum_terakhir', 'ilike', "%$search%")
        )
        ->when($polda, function ($q) use ($polda) {
            $q->whereHas('personel', function ($query) use ($polda) {
                $query->where('satuan1', 'like', "$polda-%");
            });
        })
        ->when($start_date, fn ($q) => $q->where('created_at', '>=', "$start_date 00:00:00"))
        ->when($end_date, fn ($q) => $q->where('created_at', '<=', "$end_date 23:59:59"));
    }
}
