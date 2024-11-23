<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\PetugasPolmas;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\SislapService;
use App\Traits\ExportWithCountTrait;
use Illuminate\Http\Request;

class PetugasPolmasService
{
    use ExportWithCountTrait;

    /**
     * @var SislapServiceInterface
     */
    private $sislapService;
    private $type;

    public CONST LAMPIRAN_FILE_INDEX = 5;

    public $columns = [
        'polda',
        'polres',
        'jumlah_rw',
        'jumlah_petugas_wilayah',
        'jumlah_petugas_kawasan',
        'lampiran_file',
        'jumlah_sdh_pelatihan_polmas',
    ];

    public function __construct($type = null)
    {
        $this->sislapService = new SislapService();
        $this->type = $type;
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

        return PetugasPolmas::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
                'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'petugas_polmas.user_id')
                ->where('personel.satuan1', 'ilike', $polda.'-%');
        })
        ->where(fn($q) => (
            $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function ($query) {
                return $query->where('polda', auth()->user()->personel->polda);
            })
                ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function ($query) {
                    return $query->where('polres', auth()->user()->personel->polres);
                })
                ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('polda', 'ilike', '%'.$search .'%')
                            ->orWhere('polres', 'ilike', '%'.$search .'%')
                            ->orWhere('jumlah_petugas_kawasan', 'ilike', '%'.$search .'%')
                            ->orWhere('jumlah_petugas_wilayah', 'ilike', '%'.$search .'%')
                            ->orWhere('jumlah_sdh_pelatihan_polmas', 'ilike', '%'.$search .'%')
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
                ->when($this->type, function ($query) {
                    $type = $this->type === 'kawasan' ? 'jumlah_petugas_kawasan' : 'jumlah_petugas_wilayah';
                    return $query->selectRaw("sum($type) as total")->select('kode_satuan');
                })
        ));
    }
}

// return $query->where('polda', 'ilike', "%$search%")
//                 ->orWhere('polres', 'ilike', "%$search%")
//                 ->orWhere('jumlah_petugas_kawasan','ilike', "%$search%")
//                 ->orWhere('jumlah_petugas_wilayah','ilike', "%$search%")
//                 ->orWhere('jumlah_sdh_pelatihan_polmas','ilike', "%$search%");
