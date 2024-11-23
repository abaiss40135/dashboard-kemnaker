<?php

namespace App\Services\Sislap\Lapsubjar\Bintibsos;

use App\Models\Personel;
use App\Models\Sislap\Lapsubjar\Bintibsos\DataJumlahAnggota;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataJumlahAnggotaService implements ExportInterface
{
    private $sislapService;

    public function __construct(SislapServiceInterface $sislapService)
    {
        $this->sislapService = $sislapService;
    }

    public function search(array $request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export(array $request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    protected function getQuery($request)
    {
        return DataJumlahAnggota::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when(array_key_exists('search', $request) && $request['search'], function ($query) use($request) {
            $search = $request['search'];
            $query->where(function ($query) use ($search) {
                $query->where('kesatuan', 'ilike', '%'.$search.'%')
                    ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                    ->orWhereHas('personel', function ($q) use ($search) {
                        $q->where('satuan1', 'ilike', '%'.$search . '%')
                            ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                    });
            });
        })->when(array_key_exists('polda', $request) && $request['polda'], function ($query) use($request) {
            $polda = $request['polda'];
            $query->where(function($q) use($polda){
                $kode_satuan = Personel::where('satuan1', 'ilike', '%'.$polda.'%')->first()->kode_satuan;
                $polres_list = array_map(function($item){
                    return $item['nama_satuan'];
                }, \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true));
                $polres_list[] = $polda;

                $q->whereIn('kesatuan', $polres_list)
                    ->orWhereHas('personel', function ($q) use ($polda) {
                        $q->where('satuan1', 'ilike', '%'.$polda . '%');
                    });
            });
        })->when(array_key_exists('start_date', $request) && $request['start_date'], function ($query) use($request) {
            $start_date = $request['start_date'];
            $query->whereDate('created_at', '>=', $start_date);
        })->when(array_key_exists('end_date', $request) && $request['end_date'], function ($query) use($request) {
            $end_date = $request['end_date'];
            $query->whereDate('created_at', '<=', $end_date);
        });
    }
}
