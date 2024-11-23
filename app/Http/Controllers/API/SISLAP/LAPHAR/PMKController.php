<?php

namespace App\Http\Controllers\API\SISLAP\LAPHAR;

use App\Http\Controllers\Controller;
use App\Http\Resources\SISLAP\LAPHAR\PMKCollection;
use App\Models\Sislap\Nonlapbul\PenyakitMulutKuku;
use App\Services\Sislap\Nonlapbul\PenyakitMulutKukuService;
use Illuminate\Http\Request;

class PMKController extends Controller
{
    /**
     * @var PenyakitMulutKukuService
     */
    private $penyakitMulutKukuService;

    public function __construct(PenyakitMulutKukuService $penyakitMulutKukuService)
    {
        $this->penyakitMulutKukuService = $penyakitMulutKukuService;
    }

    public function get(Request $request)
    {
        $query = $this->penyakitMulutKukuService->getQuery($request)
            ->whereHas('approval', function ($query) {
                $query->whereIn('level', ['mabes', 'polda'])
                    ->where(function ($query) {
                        $query->whereNull('is_approve')
                            ->orWhere('is_approve', true);
                    });
            })->latest();
        return new PMKCollection($query->paginate($request->per_page ?: 10, ['*'])->withQueryString());
    }

    public function store(Request $request)
    {
    }

    public function show(PenyakitMulutKuku $penyakitMulutKuku)
    {
    }

    public function update(Request $request, PenyakitMulutKuku $penyakitMulutKuku)
    {
    }

    public function destroy(PenyakitMulutKuku $penyakitMulutKuku)
    {
    }
}
