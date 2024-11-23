<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus;

use App\Http\Requests\InputDataSenpiAmunisiPolsusRequest;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Provinsi;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataSenpi;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataAmunisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputDataSenpiAmunisiPolsusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($jenisPolsus)
    {
        $jenisPolsus = str_replace("-", "_", $jenisPolsus);

        $instansi = null;
        if($jenisPolsus == 'polsus_pwp3k' || $jenisPolsus == 'polsus_karantina_ikan') {
            $instansi = Instansi::find(1);
        } else if($jenisPolsus == 'polhut_lhk') {
            $instansi = Instansi::find(2);
        } else if($jenisPolsus == 'polsuspas') {
            $instansi = Instansi::find(3);
        } else if($jenisPolsus == 'polsus_cagar_budaya') {
            $instansi = Instansi::find(4);
        } else if($jenisPolsus == 'polsus_barantan') {
            $instansi = Instansi::find(5);
        } else if($jenisPolsus == 'polsus_dishubdar') {
            $instansi = Instansi::find(6);
        } else if($jenisPolsus == 'polhut_perhutani') {
            $instansi = Instansi::find(7);
        } else if($jenisPolsus == 'polsuska') {
            $instansi = Instansi::find(8);
        } else if($jenisPolsus == 'polsus_satpol_pp') {
            $instansi = Instansi::find(9);
        }

        return view('administrator.sislap.lapsubjar.si-polsus.input-data-senpi-amunisi', [
            'province' => Provinsi::orderBy("code")->pluck('name', 'code'),
            'instansi' => $instansi,
            'jenis_polsus' => $jenisPolsus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(InputDataSenpiAmunisiPolsusRequest $request)
    {
        $except = 'null';
        if($request->instansi_id == '8') {
            $except = 'kategori_daops';
        } else if($request->instansi_id == '7') {
            $except = 'kategori_unit';
        } else if($request->instansi_id == '3') {
            $except = 'kategori_lapas';
        } else if($request->instansi_id == '2') {
            $except = 'kategori_balai';
        }

        $data = collect(array_merge($request->validated(), [
            'kategori' => $request?->$except,
            "user_id" => auth()->id() ?? random_int(1,888),
        ]))?->except($except);

        DataSenpi::create($data->except(['amunisi_panjang', 'amunisi_genggam'])->toArray());

        DataAmunisi::create($data->except(['senpi_panjang', 'senpi_genggam'])->toArray());

        $jenisPolsus = str_replace('_', '-', $request->jenis_polsus);
        $this->flashSuccess('Berhasil menginputkan data senpi dan amunisi');
        return redirect()->route('input-data-senpi-amunisi.index', $jenisPolsus);
    }

    public function detailData($dataSenpi, $dataAmunisi)
    {
        $dataSenpi = DataSenpi::whereIn('id', explode(',', $dataSenpi))->get();
        $dataAmunisi = DataAmunisi::whereIn('id', explode(',', $dataAmunisi))->get();

        $result = [];

        foreach($dataSenpi as $key => $senpi) {
            $result["provinsi"] = $senpi->provinsi;
            $result["kabupaten"] = $senpi->kabupaten;
            $result["kategori"] = $senpi->kategori;
            $result["senpi"][$key]["email"] = $senpi->user->email;
            $result["senpi"][$key]["id"] = $senpi->id;
            $result["senpi"][$key]["panjang"] = $senpi->senpi_panjang;
            $result["senpi"][$key]["genggam"] = $senpi->senpi_genggam;
            $result["senpi"][$key]["created_at"] = $senpi->created_at->format('d F Y H:i');
        }

        foreach($dataAmunisi as $key => $amunisi) {
            $result["amunisi"][$key]["id"] = $amunisi->id;
            $result["amunisi"][$key]["email"] = $senpi->user->email;
            $result["amunisi"][$key]["panjang"] = $amunisi->amunisi_panjang;
            $result["amunisi"][$key]["genggam"] = $amunisi->amunisi_genggam;
            $result["amunisi"][$key]["created_at"] = $amunisi->created_at->format('d F Y H:i');
        }

        return response()->json($result);
    }

    public function update(Request $request, $jenisPolsus, $dataSenpi, $dataAmunisi)
    {
        $data = $request->validate([
            '*_senpi_genggam' => "required|numeric",
            '*_senpi_panjang' => "required|numeric",
            '*_amunisi_genggam' => "required|numeric",
            '*_amunisi_panjang' => "required|numeric",
        ], [
            '*_senpi_genggam.required' => "Jumlah senpi genggam tidak boleh kosong",
            '*_senpi_genggam.numeric' => "Jumlah senpi genggam harus berupa angka",
            '*_senpi_panjang.required' => "Jumlah senpi panjang tidak boleh kosong",
            '*_senpi_panjang.numeric' => "Jumlah senpi panjang harus berupa angka",
            '*_amunisi_genggam.required' => "Jumlah amunisi genggam tidak boleh kosong",
            '*_amunisi_genggam.numeric' => "Jumlah amunisi genggam harus berupa angka",
            '*_amunisi_panjang.required' => "Jumlah amunisi panjang tidak boleh kosong",
            '*_amunisi_panjang.numeric' => "Jumlah amunisi panjang harus berupa angka",
        ]);

        try {
            DB::beginTransaction();
            $id_senpi = explode(',', $dataSenpi);
            $id_amunisi = explode(',', $dataAmunisi);

            foreach($id_senpi as $id) {
                $senpi = DataSenpi::find($id);
                $senpi->update([
                    'senpi_panjang' => $request[$id . "_senpi_panjang"],
                    'senpi_genggam' => $request[$id . "_senpi_genggam"],
                ]);
            }

            foreach($id_amunisi as $id) {
                $amunisi = DataAmunisi::find($id);
                $amunisi->update([
                    'amunisi_panjang' => $request[$id . "_amunisi_panjang"],
                    'amunisi_genggam' => $request[$id . "_amunisi_genggam"],
                ]);
            }
            DB::commit();

            $jenisPolsus = str_replace('_', '-', $jenisPolsus);

            $this->flashSuccess('Berhasil mengupdate data senpi dan amunisi');
            return redirect()->route('data-senpi-amunisi.' . $jenisPolsus . '.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->flashError('Gagal mengupdate data senpi dan amunisi, terjadi kesalahan pada server');
            return redirect()->route('input-data-senpi-amunisi.index', $request->jenis_polsus);
        }
    }

    public function destroy($jenisPolsus, $dataSenpi, $dataAmunisi)
    {
        try {
            DB::beginTransaction();
            DataSenpi::whereIn('id', explode(',', $dataSenpi))->delete();
            DataAmunisi::whereIn('id', explode(',', $dataAmunisi))->delete();
            DB::commit();

            $jenisPolsus = str_replace('_', '-', $jenisPolsus);

            $this->flashSuccess('Berhasil menghapus data senpi dan amunisi');
            return redirect()->route('data-senpi-amunisi.' . $jenisPolsus . '.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->flashError('Gagal menghapus data senpi dan amunisi, terjadi kesalahan pada server');
            return redirect()->route('data-senpi-amunisi.' . $jenisPolsus . '.index');
        }
    }
}
