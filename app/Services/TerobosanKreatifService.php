<?php

namespace App\Services;

use App\Http\Traits\FileUploadTrait;
use App\Models\Laporan\LaporanKegiatan\Kreatifitas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TerobosanKreatifService
{
    use FileUploadTrait;

    public function getDataTable(Request $r)
    {
        $collection = Kreatifitas::query()
            ->with(['personel:user_id,handphone', 'lokasi_tugas'])
            ->when(isset($r->search), fn ($q) =>
            $q->where('nama_bhabin', 'ilike', '%'.$r->search.'%')
                ->orWhere('judul', 'ilike', '%'.$r->search.'%')
                ->orWhere('pic', 'ilike', '%'.$r->search.'%')
            )
            ->when(isset($r->provinsi), fn ($q) =>
                $q->whereHas('lokasiPenugasans', fn ($q) =>
                    $q->where('province_code', $r->provinsi)
                    ->when(isset($r->kota), fn ($q) => $q->where('city_code', $r->kota))
                )
            )
            ->when(isset($r->start_date) && isset($r->end_date), fn ($q) =>
                $q->whereBetween('created_at', [$r->start_date, $r->end_date])
            );

        return DataTables::eloquent($collection)
            ->addColumn('action', function ($c) {
                $handphone = empty($c->personel->handphone)
                    ? null
                    : ($c->personel->handphone[0] === '0'
                        ? 'tel:62'.substr($c->personel->handphone, 1)
                        : $c->personel->handphone);
                $is_disabled = $handphone ? '' : ' disabled';

                return '<a href="'.$handphone.'" class="mb-2 btn btn-sm btn-warning btn-block'.$is_disabled.'">
                            <i class="fas fa-phone"></i><br>Telepon
                        </a>
                        <a href="'.route('download', ['url' => $c->file]).'">
                            <button type="submit" class="mb-2 btn btn-sm bg-teal btn-block">
                                <i class="fas fa-download"></i><br>Unduh
                            </button>
                        </a>
                        <button class="btn-delete btn btn-sm btn-danger btn-block" data-id="'.$c->id.'">
                            <i class="fas fa-trash"></i><br>Hapus
                        </button>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function delete($id)
    {
        $item = Kreatifitas::find($id);
        $this->deleteFiles($item->file);
        $item->delete();
    }
}
