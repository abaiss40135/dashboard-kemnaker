<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\PembinaPolmas;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\SislapService;
use App\Traits\ExportWithCountTrait;
use Illuminate\Http\Request;

class PembinaPolmasService
{
    use ExportWithCountTrait;

    public const INDEX_LAMPIRAN_FILE = 4;

    /**
     * @var SislapServiceInterface
     */
    private $sislapService;
    private $type;

    public $columns = [
        'polda',
        'polres',
        'jumlah_pembina_polda',
        'jumlah_pembina_polres',
        'lampiran_file'
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

        return PembinaPolmas::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
                'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'pembina_polmas.user_id')
                ->where('personel.satuan1', 'ilike', $polda.'-%');
        })
        ->where(fn($q) => (
            $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function ($query) {
                return $query->where('polda', auth()->user()->personel->polda);
            })
                ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function ($query) {
                    return $query->where('polres', auth()->user()->personel->polres);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('polda',           'ilike', "%$search%")
                        ->orWhere('polres',          'ilike', "%$search%")
                        ->orWhere('jumlah_pembina_polda',    'ilike', "%$search%")
                        ->orWhere('jumlah_pembina_polres', 'ilike', "%$search%");
                })
                ->when($start_date, function ($query) use ($start_date) {
                    return $query->where('created_at', '>=', $start_date . ' 00:00:00');
                })
                ->when($end_date, function ($query) use ($end_date) {
                    return $query->where('created_at', '<=', $end_date . ' 23:59:59');
                })
                ->when($this->type, function ($query) {
                    return $query->selectRaw('sum(jumlah_pembina_polda) + sum(jumlah_pembina_polres) as total')->select('kode_satuan');
                })
        ));
    }
}