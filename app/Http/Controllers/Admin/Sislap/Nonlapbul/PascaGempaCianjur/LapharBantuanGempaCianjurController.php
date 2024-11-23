<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul\PascaGempaCianjur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\PenangananGempaCianjur\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\PenangananGempaCianjur\UpdateRequest;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\BantuanPascaGempa;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisGiatPascaGempa;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisLaporanPascaGempa;
use App\Services\SislapService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LapharBantuanGempaCianjurController extends Controller
{
    protected $model = BantuanPascaGempa::class;
    protected $service;

    public function __construct()
    {
        $this->service = new SislapService();
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.pasca-gempa-cianjur.bantuan.index', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        return view('administrator.sislap.nonlapbul.pasca-gempa-cianjur.bantuan.create');
    }

    public function store(StoreRequest $request)
    {
        $user   = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level  = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        try {
            DB::transaction(function () use ($level, $user, $request, $kode_satuan) {
                foreach ($request->validated()['data'] as $item) {
                    $jenis_kegiatan = JenisGiatPascaGempa::firstOrCreate(
                        ['slug' => $item['jenis_kegiatan']],
                        ['nama' => $item['jenis_kegiatan_text'], 'created_by' => $user->id]
                    );

                    JenisLaporanPascaGempa::firstOrCreate([
                        'jenis_giat_pasca_gempa_id' => $jenis_kegiatan->id,
                        'jenis_laporan' => 'BANTUAN'
                    ]);

                    $laporan = BantuanPascaGempa::create([
                        'personel_id' => $item['personel_id'],
                        'district_code' => $item['district_code'],
                        'lokasi_kegiatan' => $item['lokasi'],
                        'tanggal' => $item['tanggal'],
                        'uraian_kegiatan' => $item['uraian_kegiatan'],
                        'jenis_kegiatan_id' => $jenis_kegiatan->id,
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan ?? "000000000"
                    ]);

                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                }
            });

            return $this->responseSuccess([
                'message' => 'Laporan berhasil disimpan'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $laporan = BantuanPascaGempa::with('personel', 'kecamatan', 'jenis_kegiatan')->findOrFail($id);
        return view('administrator.sislap.nonlapbul.pasca-gempa-cianjur.bantuan.edit', [
            'laporan' => $laporan
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $laporan = BantuanPascaGempa::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($laporan, $data) {
                $jenis_kegiatan = JenisGiatPascaGempa::firstOrCreate(
                    ['slug' => $data['jenis_kegiatan']],
                    ['nama' => $data['jenis_kegiatan_text'], 'created_by' => auth()->user()->id]
                );

                JenisLaporanPascaGempa::firstOrCreate([
                    'jenis_giat_pasca_gempa_id' => $jenis_kegiatan->id,
                    'jenis_laporan' => 'PENANGANAN'
                ]);

                $laporan->update([
                    'personel_id'       => $data['personel_id'],
                    'district_code'     => $data['district_code'],
                    'lokasi_kegiatan'   => $data['lokasi'],
                    'tanggal'           => $data['tanggal'],
                    'uraian_kegiatan'   => $data['uraian_kegiatan'],
                    'jenis_kegiatan_id' => $jenis_kegiatan->id
                ]);
            });
            $this->flashSuccess('Laporan berhasil diubah');
            return redirect()->route('bantuan-pasca-gempa-cianjur.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception);
            return redirect()->back();
        }
    }

    public function destroy($id) {}


    public function search(Request $request) {
        $search = $request->search;
        $polda = $request->polda;
        $polres = $request->polres;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $query = BantuanPascaGempa::query()->with('approvals', 'approval', 'kecamatan')
            ->when($search, fn ($q) =>
                $q->whereHas('personel', fn ($q)=>
                    $q->where('nama', 'ilike', "%$search%")
                        ->orWhere('jabatan', 'ilike', "%$search%")
                )
                ->orWhereHas('jenis_kegiatan', fn ($q) => $q->where('nama', 'ilike', "%$search%"))
                ->orWhereHas('kecamatan', fn ($q) =>
                    $q->where('name', 'ilike', "%$search%")
                      ->orWhereHas('kota', fn ($q) => $q->where('name', 'ilike', "%$search%")
                        ->orWhereHas('provinsi', fn ($q) =>$q->where('name', 'ilike', "%$search%")
                      ))
                )
                ->orwhere('lokasi_kegiatan', 'like', "%$search%")
                ->orWhere('uraian_kegiatan', 'like', "%$search%")
            )
            ->when($polda, fn ($q) =>
                $q->join('personel', 'personel.user_id', '=', 'sislap_bantuan_pasca_gempa.user_id')
                  ->where('personel.satuan1', 'like', "$polda-%")
            )
            ->when($polres, fn ($q) =>
                $q->join('personel', 'personel.user_id', '=', 'sislap_bantuan_pasca_gempa.user_id')
                  ->where('personel.satuan2', 'like', "$polres-%")
            )
            ->when($start_date, fn ($q) => $q->where('created_at', '>=', "$start_date 00:00:00"))
            ->when($end_date, fn ($q) => $q->where('created_at', '<=', "$end_date 23:59:59"));

        $result = $this->service->filterQueryByRole($query, 5)->through(function ($item) {
            $alamat_lengkap = "{$item->lokasi_kegiatan}, {$item->kecamatan->long_location_name}";
            $kesatuan = ($item->personel?->polsek ? "{$item->personel->polsek}, " : '')
                        .($item->personel?->polres ? "{$item->personel->polres}, " : '')
                        .$item->personel->polda;

            return [
                'id'               => $item->id,
                'need_approve'     => $item->need_approve,
                'nama_petugas'     => $item->personel->nama,
                'jabatan_petugas'  => $item->personel->jabatan,
                'kesatuan_petugas' => $kesatuan,
                'lokasi_kegiatan'  => $alamat_lengkap,
                'waktu_kegiatan'   => Carbon::createFromFormat('Y-m-d', $item->tanggal)
                                            ->translatedFormat(config('app.long_date_format')),
                'jenis_kegiatan'   => $item->jenis_kegiatan->nama,
                'uraian_kegiatan'  => $item->uraian_kegiatan,
                'tanggal_laporan'  => $item->created_at->format('Y-m-d'),
                'approvals'        => $item->approvals->map(fn ($approval) => [
                    'id'           => $approval->id,
                    'keterangan'   => $approval->keterangan,
                    'level'        => $approval->level,
                    'status'       => $approval->status,
                    'waktu'        => $approval->waktu
                ]),
                'approval'         => $item->approval
                ? [
                    'id'           => $item->approval->id,
                    'keterangan'   => $item->approval->keterangan,
                    'level'        => $item->approval->level,
                    'status'       => $item->approval->status,
                    'waktu'        => $item->approval->waktu
                ] : null,
            ];
        });

        return response()->json($result);
    }
}
