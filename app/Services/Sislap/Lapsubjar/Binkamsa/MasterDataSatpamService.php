<?php

namespace App\Services\Sislap\Lapsubjar\Binkamsa;

use App\Models\Sislap\Lapsubjar\Binkamsa\MasterDataSatpam;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class MasterDataSatpamService implements ExportInterface
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

        return MasterDataSatpam::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, fn ($q) => $q->where('no_reg', 'ilike', "%$search%")
            ->orWhere('nik', 'ilike', "%$search%")
            ->orWhere('nama', 'ilike', "%$search%")
            ->orWhere('tanggal_lahir', 'ilike', "%$search%")
            ->orWhere('alamat', 'ilike', "%$search%")
            ->orWhere('tinggi_berat_badan', 'ilike', "%$search%")
            ->orWhere('gol_darah', 'ilike', "%$search%")
            ->orWhere('rumus_sidik_jari', 'ilike', "%$search%")
            ->orWhere('handphone', 'ilike', "%$search%")
            ->orWhere('email', 'ilike', "%$search%")
            ->orWhere('dikum_terakhir', 'ilike', "%$search%")
            ->orWhere('npwp', 'ilike', "%$search%")
            ->orWhere('perusahaan', 'ilike', "%$search%")
            ->orWhere('jabatan', 'ilike', "%$search%")
            ->orWhere('alamat_kantor', 'ilike', "%$search%")
            ->orWhere('nomor_kantor', 'ilike', "%$search%")
            ->orWhere('email_perusahaan', 'ilike', "%$search%")
            ->orWhere('dik_terakhir_satpam', 'ilike', "%$search%")
            ->orWhere('tahun_lulus', 'ilike', "%$search%")
            ->orWhere('is_ex_tni_polri', 'ilike', "%$search%")
            ->orWhere('pangkat', 'ilike', "%$search%")
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
