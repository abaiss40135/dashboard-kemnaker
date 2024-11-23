<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasLama;

use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Binpolmas\KommasKbppExport as TemplateLaporan;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\KommasKbpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KommasKbppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.kommas-kbpp.index');
    }


    public function templateExcel()
    {
        return Excel::download(new Templatelaporan, 'Data Kommas KBPP Polri.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binpolmas.kommas-kbpp.index', ['laporan' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        try {
            DB::transaction(function () use ($user_id, $request) {
                foreach($request->laporan as $item) {
                    KommasKbpp::create([
                        'kesatuan' => $item['kesatuan'],
                        'kbpp_polri' => $item['kbpp_polri'],
                        'senkom' => $item['senkom'],
                        'fkppi' => $item['fkppi'],
                        'user_id' => $user_id
                    ]);
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('kommas-kbpp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            KommasKbpp::find($id)->update([
                'kesatuan' => $request->kesatuan,
                'kbpp_polri' => $request->kbpp_polri,
                'senkom' => $request->senkom,
                'fkppi' => $request->fkppi
            ]);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('kommas-kbpp.index');
    }

    public function destroy($id)
    {
        try {
            KommasKbpp::where('id', $id)->delete();
            $this->flashSuccess('laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('kommas-kbpp.index');
    }

    public function search(Request $request) {
        $collection = KommasKbpp::where( function ($query) use ($request) {
            $query->where('kesatuan', 'ilike', '%'.$request->search.'%')
            ->orWhere('kbpp_polri', 'ilike', '%'.$request->search.'%')
            ->orWhere('senkom', 'ilike', '%'.$request->search.'%')
            ->orWhere('fkppi', 'ilike', '%'.$request->search.'%');
        });

        $collection = $collection->latest()->paginate(10, ['*'], 'page');

        return response()->json($collection);
    }
}
