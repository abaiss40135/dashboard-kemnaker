<?php


namespace App\Repositories;


use App\Models\OSS\Checklist;
use App\Repositories\Abstracts\ChecklistRepositoryAbstract;

class ChecklistRepository extends ChecklistRepositoryAbstract
{

    public function model()
    {
        return Checklist::class;
    }

    public function filterData(array $filter, $query)
    {
        $query->where('flag_perpanjangan', 'N');
        $query->when(auth()->user()->role() == 'bujp', function ($query) {
            return $query->whereHas('nib', function ($query){
                $query->where('nib', auth()->user()->bujp->nib);
            });
        });
        if (!empty($filter['nib'])){
            $query->whereHas('nib', function ($query) use ($filter){
                $query->where('nib', $filter['nib']);
            });
        }
        if (!empty($filter['type'])) {
            $query->whereHas('riwayatSio', function ($query) {
                $query->where('type', request('type'));
            });
        }
    }
}
