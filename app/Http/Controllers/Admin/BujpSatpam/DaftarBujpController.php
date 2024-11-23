<?php

namespace App\Http\Controllers\Admin\BujpSatpam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\TransaksiBujp\StorePendaftaranSioRequest;
use App\Mail\PendaftaranSioMail as MailPendaftaranSio;
use App\Models\Bujp;
use App\Models\PendaftaranSio;
use App\Models\StatusSio;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DaftarBujpController extends Controller
{
    private $usaha;

    private function addFile($file){
        $this->uploadPath = 'bujp/' . $this->usaha . '/pendaftaran sio baru/' . Carbon::now()->isoFormat('dddd, D MMMM Y');
        return $this->saveFiles($file);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = User::where('email', auth()->user()->email)->pluck('id');
        $bujp_id = Bujp::where('user_id', $user_id)->pluck('id');
        $arrayData = [
            'data' => PendaftaranSio::where('bujp_id', $bujp_id)->latest()->paginate(10),
            'status' => StatusSio::orderBy('id')->pluck('status', 'id'),
            'status_terakhir' => PendaftaranSio::where('bujp_id', $bujp_id)->latest()->first('status')->status
        ];

        return view('bujp.transaksi-bujp.pendaftaran-sio.index', $arrayData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bujp = auth()->user()->bujp;
        return view('bujp.transaksi-bujp.pendaftaran-sio.daftar', compact('bujp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(StorePendaftaranSioRequest $request)
    {
        $this->usaha = auth()->user()->bujp->nama_badan_usaha;

        DB::beginTransaction();
        try{
            $pendaftaranSio = new PendaftaranSio();
            $pendaftaranSio->bujp_id = auth()->user()->bujp->id;
            $pendaftaranSio->nib = $request->nib;
            $pendaftaranSio->nama_perusahaan = $request->nama_perusahaan;
            $pendaftaranSio->alamat = $request->alamat;
            $pendaftaranSio->jenis_usaha = json_encode($request->jenis_usaha);
            $pendaftaranSio->nama_polda = Arr::last(explode(',', $request->nama_polda));
            $pendaftaranSio->save();

            foreach($request->berkas_pendaftaran_sio as $key => $gambar_file){
                $pendaftaranSio->berkasPendaftaran()->create([
                    'nama' => $this->addFile($gambar_file),
                    'file' => $this->addFile($gambar_file),
                    'jenis_berkas' => $key
                ]);
            }
            Mail::to(auth()->user()->email)
                ->cc(config('mail.cc_email'))
                ->send(new MailPendaftaranSio($pendaftaranSio->nama_polda));
            $this->flashSuccess('Berhasil menambahkan pengajuan sio');
            DB::commit();
            return redirect()->route('transaksi.pendaftaran-sio.index');
        } catch (Exception $e){
            DB::rollBack();
            $this->flashError($e->getMessage());
            return back();
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
