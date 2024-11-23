<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat;
use App\Traits\BinpolmasAlamatTrait;
use App\Traits\ExportWithCountTrait;
use App\Services\{
    Interfaces\ExportInterface,
    Interfaces\Sislap\SislapServiceInterface,
    SislapService
};

class DataKomunitasMasyarakatService implements ExportInterface
{
    use BinpolmasAlamatTrait;
    use ExportWithCountTrait;

    /**
     * @var SislapServiceInterface
     */
    private $sislapService;
    public $columns = [
        'nama_kommas',
        'polda',
        'polres',
        'akta_notaris',
        'tanggal_akta_notaris',
        'npwp',
        'sumber_dana',
        'bidang_kegiatan',
        'jml_anggota',
        'nama_ketua',
        'no_hp_ketua',
        'provinsi_code',
        'kabupaten_code',
        'kecamatan_code',
        'desa_code',
        'jalan',
        'rt',
        'rw',
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

    protected function getQuery($request, $withApproval = null)
    {
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return DataKomunitasMasyarakat::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with(
                'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2'
            );
        })
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'data_komunitas_masyarakats.user_id')
                ->where('personel.satuan1', 'ilike', $polda . '-%');
        })
        ->where(fn($q) => (
            $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function ($q) {
                // filter polda by user
                return $q->where('polda', auth()->user()->personel->polda);
            })
                ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function ($q) {
                    // filter polda by user
                    return $q->where('polres', auth()->user()->personel->polres);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('nama_kommas', 'ilike', "%$search%")
                        ->orWhere('polda',           'ilike', "%$search%")
                        ->orWhere('polres',          'ilike', "%$search%")
                        ->orWhere('akta_notaris',    'ilike', "%$search%")
                        ->orWhere('tanggal_akta_notaris', 'ilike', "%$search%")
                        ->orWhere('npwp',            'ilike', "%$search%")
                        ->orWhere('alamat',          'ilike', "%$search%")
                        ->orWhere('sumber_dana',     'ilike', "%$search%")
                        ->orWhere('bidang_kegiatan', 'ilike', "%$search%")
                        ->orWhere('nama_ketua',      'ilike', "%$search%")
                        ->orWhere('no_hp_ketua',     'ilike', "%$search%");
                })
                ->when($start_date, function ($query) use ($start_date) {
                    return $query->where('created_at', '>=', $start_date . ' 00:00:00');
                })
                ->when($end_date, function ($query) use ($end_date) {
                    return $query->where('created_at', '<=', $end_date . ' 23:59:59');
                })
        ));
    }


}

