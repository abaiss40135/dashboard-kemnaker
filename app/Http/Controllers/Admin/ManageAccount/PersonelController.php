<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Http\Controllers\Controller;
use App\Models\Personel;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PersonelController extends Controller
{
    public function getSelect2()
    {
        abort_if(!auth()->user()->haveLevel(3) && Gate::denies('pengelolaan_akun_access'), Response::HTTP_FORBIDDEN, 'Anda tidak memiliki otoritas untuk akses layanan ini.');
        $query = Personel::query();
        if (!roles(['administrator'])) {
            $query->whereRaw("(CASE
               WHEN personel.satuan7 IS NOT NULL THEN split_part(personel.satuan7::text, '-'::text, 2)
               WHEN personel.satuan6 IS NOT NULL THEN split_part(personel.satuan6::text, '-'::text, 2)
               WHEN personel.satuan5 IS NOT NULL THEN split_part(personel.satuan5::text, '-'::text, 2)
               WHEN personel.satuan4 IS NOT NULL THEN split_part(personel.satuan4::text, '-'::text, 2)
               WHEN personel.satuan3 IS NOT NULL THEN split_part(personel.satuan3::text, '-'::text, 2)
               WHEN personel.satuan2 IS NOT NULL THEN split_part(personel.satuan2::text, '-'::text, 2)
               WHEN personel.satuan1 IS NOT NULL THEN split_part(personel.satuan1::text, '-'::text, 2)
               ELSE NULL::text
               END) like ?", [auth()->user()->personel->kode_satuan . '%']);
               if (roles(['operator_bagopsnalev_polres', 'operator_bagopsnalev_polda'])) {
                    $query->whereHas('user.roles', fn ($q) => $q->where('name', 'bhabinkamtibmas'));
               }
        }

        $query->when(request()->has('q'), function ($query) {
            $query->where(function ($query) {
                $query->where('nama', 'ilike', '%' . request('q') . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('nrp', request('q'));
                    });
            });
        });
        $query->limit(10);
        if (request()->wantsJson()) {
            return response()->json($this->mapForSelect2($query->get()));
        }
        return $this->mapForSelect2($this->mapForSelect2($query->get()));
    }

    public function show(Personel $personel)
    {
        return $personel->load('ketua_rw.kategori_kegiatan', 'ketua_rw.kategori_kerawanan', 'ketua_rw.desa');
    }

    private function mapForSelect2($data)
    {
        return $data->map(function ($item) {
            return [
                'id' => $item->personel_id,
                'text' => request('withPangkat') ? "$item->pangkat $item->nama" : $item->nama,
                'jabatan' => $item->jabatan,
                'polres' => $item->polres,
            ];
        });
    }
}
