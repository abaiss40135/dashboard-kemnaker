<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\SakaBhayangkara as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Bintibsos\SakaBhayangkara;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SakaBhayangkaraController extends Controller
{
    protected $model = SakaBhayangkara::class;

    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.saka-bhayangkara.index', ['model' => addcslashes($this->model, "\\")]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user   = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level  = end($levels);

        $personel   = $user->personel;
        $satuan     = $personel->satuan7 ??
                      $personel->satuan6 ??
                      $personel->satuan5 ??
                      $personel->satuan4 ??
                      $personel->satuan3 ??
                      $personel->satuan2 ??
                      $personel->satuan1;
        $kode_satuan = preg_match('/\d*$/', $satuan, $out) ? $out[0] : null;

        try {
            DB::transaction(function () use ($level, $user, $request, $kode_satuan) {
                foreach($request->laporan as $item) {
                    $laporan = SakaBhayangkara::create([
                        'kesatuan'      => $item['kesatuan'],
                        'uraian'        => $item['uraian'],
                        'sasaran'       => $item['sasaran'],
                        'hasil'         => $item['hasil'],
                        'keterangan'    => $item['keterangan'],
                        'user_id'       => $user->id,
                        'kode_satuan'   => $kode_satuan
                    ]);
                    if ($level === 'polda'){
                        $laporan->approvals()->create([
                            'keterangan'    => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level'         => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('saka-bhayangkara.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            SakaBhayangkara::find($id)->update([
                'kesatuan' => $request->kesatuan,
                'uraian' => $request->uraian,
                'keterangan' => $request->keterangan,
                'sasaran' => $request->sasaran,
                'hasil' => $request->hasil,
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('saka-bhayangkara.index');
    }

    public function destroy($id)
    {
        try {
            SakaBhayangkara::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel() {
        return Excel::download(new TemplateLaporan, 'laporan kegiatan saka bhayangkara.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.bintibsos.saka-bhayangkara.index', ['laporan' => $data, 'model' => addcslashes($this->model, "\\")]);
    }

    public function search(Request $request) {
        $hak_akses  = auth()->user()->role();
        $query      = SakaBhayangkara::query()
                                ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
                                    'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
                                ->when($request->search, function ($query, $search) {
                                    return $query->where(function ($query) use ($search) {
                                            $query->where('kesatuan', 'ilike', '%'. $search .'%')
                                                ->orWhere('uraian', 'ilike', '%'.$search .'%u')
                                                ->orWhere('sasaran', 'ilike', '%'.$search .'%')
                                                ->orWhere('hasil', 'ilike', '%'.$search .'%')
                                                ->orWhere('keterangan', 'ilike', '%'.$search .'%');
                                    });
                                });

        $query->when(auth()->user()->haveRole([
                'operator_bagopsnalev_polres',
                'operator_bagopsnalev_polda',
                'operator_bagopsnalev_mabes'
            ]), function ($query) {

            $personel = auth()->user()->personel;
            if (auth()->user()->haveRole('operator_bagopsnalev_polres')) {
                return $query->where('kode_satuan', 'like', Str::after($personel->satuan2, '-') . '%');
            } else if (auth()->user()->haveRole('operator_bagopsnalev_polda')){
                return $query->where('kode_satuan', 'like', Str::after($personel->satuan1, '-') . '%')
                        ->whereHas('approvals', function ($query){
                            $query->where(function ($query) {
                                $query->whereNull('is_approve')
                                        ->orWhere('is_approve', true);
                            });
                        });
            } else if (auth()->user()->haveRole('operator_bagopsnalev_mabes')){
                return $query->where('kode_satuan', 'like', '2%')
                            ->whereDoesntHave('approval', function ($query){
                                $query->where('is_approve', false);
                            })
                            ->whereHas('approvals', function ($query){
                                $query->where(function ($query) {
                                    $query->whereNull('is_approve')
                                        ->orWhere('is_approve', true);
                                })->where('level', 'polda');
                            });
            }
        });

        $query->when(in_array($hak_akses, ['administrator', 'pimpinan_polri']), function ($query){
            return $query->whereHas('approval', function ($query){
                $query->approved()->where('level', 'mabes');
            });
        });

        $collection = $query->latest()->paginate(10, ['*'], 'page')->withQueryString();
        return response()->json($collection);
    }
}
