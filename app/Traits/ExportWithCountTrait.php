<?php

namespace App\Traits;

trait ExportWithCountTrait
{
    public function exportWithCount($request)
    {
        $query = $this->sislapService->filterQueryByRole($this->getQuery($request), 0);

        return $query->count();
    }

    public function ExportWithTotalCount($request, $column)
    {
        $query = $this->sislapService->filterQueryByRole($this->getQuery($request), 0);

        return $query->sum($column);
    }
}
