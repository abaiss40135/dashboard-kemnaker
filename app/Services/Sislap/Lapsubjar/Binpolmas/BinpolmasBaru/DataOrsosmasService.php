<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataOrsosmas;
use App\Traits\BinpolmasAlamatTrait;
use App\Traits\ExportWithCountTrait;
use App\Services\{
    Interfaces\Sislap\SislapServiceInterface,
    Interfaces\ExportInterface,
    SislapService
};

class DataOrsosmasService implements ExportInterface
{
    use BinpolmasAlamatTrait;
    use ExportWithCountTrait;

    /**
     * @var SislapServiceInterface
     */
    private $sislapService;

    public $columns = [
        'nama_orsosmas',
        'dasar_hukum',
        'tanggal_akta_notaris',
        'akta_notaris',
        'npwp',
        'alamat',
        'sumber_dana',
        'bidang_kegiatan',
        'jml_anggota',
        'nama_ketua',
        'no_hp_ketua',
        'kode_satuan',
        'provinsi_code',
        'kabupaten_code',
        'kecamatan_code',
        'desa_code',
        'jalan',
        'rt',
        'rw',
        'tanggal_dasar_hukum',
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

        return DataOrsosmas::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'ormas_hukums.user_id')
                ->where('personel.satuan1', 'ilike', $polda.'-%');
        })
        ->where(fn($q) => (
            $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function($q) {
                // filter polda by user
                return $q->where('polda', auth()->user()->personel->polda);
            })
                ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function($q) {
                    // filter polda by user
                    return $q->where('polres', auth()->user()->personel->polres);
                })
                ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('nama_orsosmas', 'ilike', '%'. $search .'%')
                            ->orWhere('polda', 'ilike', '%'.$search .'%')
                            ->orWhere('polres', 'ilike', '%'.$search .'%')
                            ->orWhere('alamat', 'ilike', '%'.$search .'%')
                            ->orWhere('nama_ketua', 'ilike', '%'.$search .'%')
                            ->orWhere('akta_notaris', 'ilike', '%'.$search .'%')
                            ->orWhere('alamat', 'ilike', '%'.$search .'%')
                            ->orWhere('npwp', 'ilike', '%'.$search .'%')
                            ->orWhere('sumber_dana', 'ilike', '%'.$search .'%')
                            ->orWhere('bidang_kegiatan', 'ilike', '%'.$search .'%')
                            ->orWhere('bidang_kegiatan', 'ilike', '%'.$search .'%')
                            ->orWhere('jml_anggota', 'ilike', '%'.$search .'%')
                            ->orWhere('nama_ketua', 'ilike', '%'.$search .'%')
                            ->orWhere('no_hp_ketua', 'ilike', '%'.$search .'%')
                            ->orWhereHas('personel', function ($q) use ($search) {
                                $q->where('satuan1', 'ilike', '%'.$search . '%')
                                    ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                            });
                    });
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
