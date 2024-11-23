<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\OpsDamaiCartenz;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class OpsDamaiCartenzService implements ExportInterface
{
    private $sislapService;
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
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

    /**
     * @param $search
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    protected function getQuery($request, $withApproval = null)
    {
        $search = $request->search;
        $date_s = $request->start_date;
        $date_e = $request->end_date;

        return OpsDamaiCartenz::query()
            ->byType($this->type)
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when(!empty($withApproval), fn ($q) =>
                $q->with(
                    'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2'
                )
            )
            ->when(!empty($search), fn ($q) =>
                $q->where('daops',      'ilike', "%$search%")
                  ->orWhere('satgas',     'ilike', "%$search%")
                  ->orWhere('jam',        'ilike', "%$search%")
                  ->orWhere('kuat_pers',  'ilike', "%$search%")
                  ->orWhere('lokasi',     'ilike', "%$search%")
                  ->orWhere('kegiatan',   'ilike', "%$search%")
                  ->orWhere('hasil',      'ilike', "%$search%")
                  ->orWhere('keterangan', 'ilike', "%$search%")
            )
            ->when(!empty($date_s), fn ($q) => $q->where('created_at', '>=', "$date_s 00:00:00"))
            ->when(!empty($date_e), fn ($q) => $q->where('created_at', '<=', "$date_e 23:59:59"));
    }
}