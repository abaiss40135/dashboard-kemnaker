<?php

namespace App\Http\Resources\SISLAP\LAPHAR;

use App\Services\Sislap\Nonlapbul\PenyakitMulutKukuService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class PMKResource extends JsonResource
{
    /**
     * @var PenyakitMulutKukuService
     */
    private $penyakitMulutKukuService;

    public function __construct($resource)
    {
        $this->resource = $resource;
        $this->penyakitMulutKukuService = new PenyakitMulutKukuService();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $initialData = [
            "id"        => $this->id,
            "tanggal"   => $this->tanggal,
            "provinsi"  => in_array($this->polres, [
                'POLRES METRO TANGERANG KOTA', 'POLRES TANGERANG SELATAN', 'POLRESTA TANGERANG'
            ]) ? 'BANTEN' : (in_array($this->polres, [
                'POLRES METRO DEPOK', 'POLRES METRO BEKASI', 'POLRES METRO BEKASI KOTA',
            ]) ? 'JAWA BARAT' : Lang::get('polda-to-province.' . $this->polda)),
            "polda"     => $this->polda,
            "polres"    => $this->polres,
        ];


        $type    = [];
        $allType = [];
        foreach (array_merge($this->penyakitMulutKukuService->kategori, ['populasi']) as $kategori) {
            $fields = [];
            foreach ($this->penyakitMulutKukuService->tipe as $jenis_hewan) {
                $field = $kategori . '_' . $jenis_hewan;
                $fields[$field] = $this->$field;
                if ($kategori === 'populasi'){
                    $fields[$field] = $this[str_replace('populasi', 'hewan', $field)];
                }
            }
            $allType += $fields;
            $type[$kategori] = $fields;
        }
        if ($request->has('kategori')) {
            $requestKategori = $request->kategori;
            if(!is_array($requestKategori)){
                $requestKategori = array($request->kategori);
            }
            return $initialData + collect($requestKategori)->flatMap(function ($item) use ($type) {
                return $type[$item] ?? [];
            })->toArray();
        }
        return array_merge($initialData, $allType);
    }

    public function with($request)
    {
        return [
            'status' => 200,
            'message' => 'Data retrieved successfully.'
        ];
    }
}
