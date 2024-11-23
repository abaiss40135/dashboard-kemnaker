<?php

namespace App\Services;

use App\Services\Interfaces\Sislap\SislapServiceInterface;

class SislapService implements SislapServiceInterface
{
    public function filterQueryByRole($query, int $paginate = 10)
    {
        $query = $this->filterByRole($query);

        return $this->get($query, $paginate);
    }

    public function countQueryByRole($query)
    {
        $query = $this->filterByRole($query);

        return $query->count();
    }

    private function filterByRole($query)
    {
        $personel = auth()->user()->personel;
        $query->when(auth()->user()->haveRole('operator_bagopsnalev_polres', 'operator_binpolmas_polres'), fn ($q) =>
            // kode_satuan is not nullable & required column,
            // 'where null' clause return no data.
            empty($personel->satuan2)
            ? $q->whereNull('kode_satuan')
            : $q->where('kode_satuan', 'like', $personel->kode_satuan.'%')
        )
        ->when(auth()->user()->haveRole('operator_bagopsnalev_polda', 'operator_binpolmas_polda'), fn ($q) =>
            empty($personel->satuan1)
            ? $q->whereNull('kode_satuan')
            : $q->where('kode_satuan', 'like', $personel->kode_satuan.'%')
                ->whereHas('approvals', fn ($q) => $q->where(fn ($q) => $q->whereNull('is_approve')
                        ->orWhere('is_approve', true)
                )
                )
        )
        ->when(auth()->user()->haveRole('operator_bagopsnalev_mabes'), fn ($q) => $q->whereHas('approval', fn ($q) => $q->whereIn('level', ['mabes', 'polda'])
                ->where(fn ($q) => $q->whereNull('is_approve')
                    ->orWhere('is_approve', true)
                )
        )
        )
        ->when(auth()->user()->haveRole(['administrator', 'pimpinan_polri']), fn ($q) =>
            /*
             * Temporary fix for administrator role
             * can see laporan who doenst have approval mabes
             */
            $q->whereHas('approval', fn ($q) =>
                $q->whereIn('level', ['mabes', 'polda', 'administrator', 'pimpinan_polri'])
                ->where(fn ($q) =>
                    $q->whereNull('is_approve')
                    ->orWhere('is_approve', true)
                    ->orWhere('is_approve', false)
                )
            )
        );

        return $query;
    }

    private function get($query, int $paginate = 10)
    {
        if ($paginate) {
            return $query->latest()->paginate($paginate, ['*'], 'page')->withQueryString();
        } else {
            return $query->orderBy('kode_satuan')->get();
        }
    }
}
