<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus\DataSenpiAmunisi;

use App\Http\Controllers\Controller;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataAmunisi;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataSenpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteDataSenpiAmunisiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, DataSenpi $dataSenpi, DataAmunisi $dataAmunisi)
    {
        try {
            DB::beginTransaction();
            $dataSenpi->delete();
            $dataAmunisi->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Data gagal dihapus, Terdapat kesalahan pada sistem');
        }
    }
}
