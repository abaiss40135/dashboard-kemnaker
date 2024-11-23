<?php

namespace App\Http\Controllers;

use App\Models\PemanfaatanInformasi;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PemanfaatanInformasiController extends Controller
{
    private function sanitizeStoreRequest(Request $request)
    {
        $type = $request->type;

        if (!preg_match('/\\\/', $type)) {
            $type = preg_replace('/(Models)([A-Z])/', '\\\$1\\\$2', $type);
        }

        if (preg_match('/\_\d/', $type)) {
            $type = \Illuminate\Support\Str::beforeLast($type, '_');
        }

        return ['type' => $type, 'id' => $request->id];
    }

    public function copyLink(Request $request)
    {
        $request = $this->sanitizeStoreRequest($request);
        $this->store($request['type'], $request['id'], PemanfaatanInformasi::COPY_LINK);
    }

    public function download(Request $request) {
        $request = $this->sanitizeStoreRequest($request);
        $this->store($request['type'], $request['id'], PemanfaatanInformasi::DOWNLOAD);
    }

    public function store(string $type, int|string $id, string $jenis_pemanfaatan)
    {
        $user_id = auth()->user()->id;

        try {
            $p_i = PemanfaatanInformasi::
                whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->firstOrCreate([
                    'user_id'      => $user_id,
                    'content_type' => $type,
                    'content_id'   => $id
                ]);

            match ($jenis_pemanfaatan) {
                PemanfaatanInformasi::DOWNLOAD => $p_i->download += 1,
                PemanfaatanInformasi::COPY_LINK => $p_i->copy_link += 1,
                default => throw new Error('Ada masalah dengan aplikasi')
            };

            $p_i->save();
            return true;
        } catch (\Exception $e) {
            return $this->responseError($e);
        }
    }

    public function getQuery(Request $r)
    {
        return PemanfaatanInformasi::select(
                'users.nrp', 'personel.nama', 'personel.pangkat',
                'personel.satuan1', 'personel.satuan2', 'personel.satuan3',
                DB::raw('(SUM(pemanfaatan_informasi.download) + SUM(pemanfaatan_informasi.copy_link)) AS total')
            )
            ->join('users', 'users.id', '=', 'pemanfaatan_informasi.user_id')
            ->join('personel', 'personel.user_id', '=', 'users.id')
            ->when((isset($r->start_date) && isset($r->end_date)), fn ($q) =>
                $q->where('pemanfaatan_informasi.created_at', '>=', $r->start_date)
                  ->where('pemanfaatan_informasi.created_at', '<=', $r->end_date)
            )
            ->when(isset($r->nrp), fn ($q) => $q->where('users.nrp', $r->nrp))
            ->when(isset($r->polda), fn ($q) => $q->where('personel.satuan1', 'like', $r->polda . '%'))
            ->groupBy(
                'users.nrp',
                'personel.nama',
                'personel.pangkat',
                'personel.satuan1',
                'personel.satuan2',
                'personel.satuan3'
            );
    }

    public function show(Request $r)
    {
        return PemanfaatanInformasi::where('nrp', $r->nrp)
               ->when((isset($r->start_date) && isset($r->end_date)), fn ($q) =>
                   $q->where('pemanfaatan_informasi.created_at', '>=', $r->start_date)
                     ->where('pemanfaatan_informasi.created_at', '<=', $r->end_date)
               )
               ->join('users', 'users.id', 'pemanfaatan_informasi.user_id')
               ->select('content_type', 'content_id', 'download', 'copy_link')
               ->get()
               ->map(function ($item) {
                    $c = $item->content;

                    $list = [];
                    $list['download'] = $item->download;
                    $list['copy_link'] = $item->copy_link;

                    if ($c->judul || $c->nama_meme || $c->nama_paparan) $list['type'] = 'image';
                    else if ($c->judul_video) $list['type'] = 'video';
                    else if ($c->nama_uu || $c->nama_naskah) $list['type'] = 'doc';

                    $list['thumbnail'] = $c->url_thumbnail
                        ?? $c->url_gambar
                        ?? '';

                    $list['file'] = $c->url_gambar
                        ?? $c->url_file_video
                        ?? $c->url_file_naskah
                        ?? $c->url_file_uu
                        ?? '';

                    $list['title'] = $c->judul
                        ?? $c->nama_meme
                        ?? $c->nama_paparan
                        ?? $c->judul_video
                        ?? $c->nama_naskah
                        ?? $c->nama_uu
                        ?? '-';

                    $list['description'] = $c->caption
                        ?? $c->deskripsi
                        ?? $c->deskripsi_naskah
                        ?? '-';

                    return $list;
               });
    }

    public function getDataTable(Request $r)
    {
        return DataTables::eloquent($this->getQuery($r))->toJson();
    }

    public function getExcel(Request $r) {
        $file = new \App\Exports\PemanfaatanInformasiExport($this->getQuery($r));

        if ($r->polda)      $r->polda      = '_'.$r->polda;
        if ($r->nrp)        $r->nrp        = '_'.$r->nrp;
        if ($r->start_date) $r->start_date = '_'.$r->start_date;
        if ($r->end_date)   $r->end_date   = '-_'.$r->end_date;
        $filename = "pemanfaatan_informasi{$r->polda}{$r->nrp}{$r->start_date}{$r->end_date}.xlsx";

        return $file->download($filename);
    }
}
