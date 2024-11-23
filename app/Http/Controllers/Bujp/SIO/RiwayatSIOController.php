<?php

namespace App\Http\Controllers\Bujp\SIO;

use App\Http\Controllers\API\OSS\OSSController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\TransaksiBujp\StorePendaftaranSioRequest;
use App\Http\Traits\FileUploadTrait;
use App\Mail\PendaftaranSioMail;
use App\Models\BerkasPendaftaranSio;
use App\Models\RiwayatSio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RiwayatSIOController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('hallo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('hallo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePendaftaranSioRequest $request)
    {
        $bujp = auth()->user()->bujp;
        $riwayatSio = RiwayatSio::find($request->riwayat_sio_id);
        $this->uploadPath = 'bujp';
        $this->folderName = $bujp->nama_badan_usaha . '/sio/' . $riwayatSio->id_izin . '/' .Carbon::now()->translatedFormat(config('app.long_date_format')) . '/';

        DB::beginTransaction();
        try{
            $polda = Arr::last(explode(',', $request->nama_polda));
            if ($riwayatSio->statusSios()->doesntExist()){
                $respReceiveLicense = (new OSSController())->receiveLicenseStatus($riwayatSio->checklist->id_izin, 'Dokumen Diterima oleh Polda');
                if ($respReceiveLicense->isServerError()){
                    // TODO Server error OSS
                }
                $riwayatSio->statusSios()->attach([1 => ['keterangan' => 'Berkas diteruskan ke ' . $polda . ' untuk proses verifikasi']]);
            }
            $riwayatSio->id_izin    = $request->id_izin;
            $riwayatSio->polda      = $polda;
            $riwayatSio->save();

            if ($request->berkas_pendaftaran_sio != null){
                foreach($request->berkas_pendaftaran_sio as $key => $gambar_file){
                    $fileName = Str::slug($bujp->nama_badan_usaha) . '-' . $key . '.' . $gambar_file->getClientOriginalExtension();
                    $this->fileName = $fileName;
                    $riwayatSio->dokumens()->updateOrCreate(['jenis_berkas' => $key], [
                        'nama' => $fileName,
                        'file' => $this->saveFiles($gambar_file)
                    ]);
                }
            }

            if ($riwayatSio->wasRecentlyCreated){
                Mail::to(auth()->user()->email)
                    ->cc(config('mail.cc_email'))
                    ->send(new PendaftaranSioMail($riwayatSio));
            }

            $this->flashSuccess('Berhasil Menambahkan Persyaratan Pengajuan SIO Baru ' . Str::title($riwayatSio->type));
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            $this->flashError($e->getMessage());
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('hallo');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id_izin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('hallo');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd('hallo');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('hallo');

    }

    /* xhr request */
    public function postStatus(Request $request)
    {
        $data = $request->all();
        $status = null;

        if ($request->invalid == 0) {
            RiwayatSio::where('id', $request->id)->update(['status' => 3]);
            $status = 'valid';
        } else {
            RiwayatSio::where('id', $request->id)->update(['status' => 2]);
            $status = 'tidak valid';
        }

        return response()->json($status);
    }

    public function validasiBerkas(Request $request, RiwayatSio $riwayatSio)
    {

        $berkas = BerkasPendaftaranSio::find($request->id);
        $berkas->update(['validasi' => $request->valid]);

        if (role('operator_polda')) {
            $riwayatSio->update(['status' => 2]);
        }
        if (role('operator_mabes')){
            $riwayatSio->update(['status' => 4]);
        }
        if (!$request->valid) {
            return response()->json('tidak valid');
        } elseif (!in_array(false, $riwayatSio->dokumens()->pluck('validasi')->toArray())) {
            return response()->json('valid');
        }
    }
}
