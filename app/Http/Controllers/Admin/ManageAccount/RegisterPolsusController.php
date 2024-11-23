<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Models\{Instansi, Kota, Polsus, Provinsi, User};
use App\Http\Controllers\Controller;
use App\Exports\Sislap\Lapsubjar\Sipolsus\RegisterPolsusExport as TemplateLaporan;
use App\Http\Requests\Register\StorePolsusRequest;
use App\Imports\RegisterPolsusImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class RegisterPolsusController extends Controller
{
    private $path_file;

    public function __construct()
    {
        $this->uploadPath = 'polsus';
        $this->folderName = 'foto_profile';
    }

    public function index() {
        $isAdmin       = auth()->user()->haveRoleID(1);
        $operatorPolda = auth()->user()->haveRoleID(24);
        $klPusat       = auth()->user()->haveRoleID(25);
        $klProvinsi    = auth()->user()->haveRoleID(26);
        $klKabupaten   = auth()->user()->haveRoleID(27);
        $province      = Provinsi::orderBy("code")->pluck('name', 'code');
        $instansis     = Instansi::get();
        $idProv        = null;
        $idKabupaten   = null;

        if($operatorPolda) {
            $provinsi_polda = getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda);
            $idProv = [
                'id' => Provinsi::firstWhere('name', strtoupper($provinsi_polda))->code,
                'name' => strtoupper($provinsi_polda)
            ];
        }

        if($klProvinsi || $klKabupaten) {
            $idProv = [
                'id' =>
                    Provinsi::firstWhere('name', 'ilike', auth()->user()?->polsus?->provinsi)?->code ?? // check if kota polsus exactly same as in table kota
                    Provinsi::firstWhere('name', 'ilike', '%'.auth()->user()?->polsus?->provinsi.'%')?->code, // otherwise, select similar with polsus kota
                'name' => auth()->user()?->polsus?->provinsi
            ];
        }

        if($klKabupaten) {
            $idKabupaten = [
                'id' =>
                    Kota::firstWhere('name', 'ilike', trim(auth()->user()?->polsus?->kabupaten))?->code ?? // check if kota polsus exactly same as in table kota
                    Kota::firstWhere('name', 'ilike', '%'.trim(auth()->user()?->polsus?->kabupaten).'%')?->code, // otherwise, select similar with polsus kota
                'name' => auth()->user()?->polsus?->kabupaten
            ];
        }

        return view('auth.register.polsus', compact(
                    'isAdmin',
                    'operatorPolda',
                    'klPusat',
                    'klProvinsi',
                    'klKabupaten',
                    'province',
                    'instansis',
                    'idProv',
                    'idKabupaten'
                )
            );
    }

    public function store(StorePolsusRequest $request)
    {
        $this->fileName = 'kta-polsus-'.Str::slug($request->nama).'.'.$request->file('filepond')->getClientOriginalExtension();

        $data = $request->except('ruang');
        $data['foto_profile'] = $this->saveFiles($request->file('filepond'));
        $data['golongan']     = str_repeat('I', $request->golongan).'/'.$request->ruang;
        $data['pangkat']      = explode('_', $request->pangkat)[0];
        $data['provinsi']     = ucwords(strtolower(trim($data['provinsi'])));
        $data['kabupaten']    = ucwords(strtolower(trim($data['kabupaten'])));

        DB::beginTransaction();
        try {
                $user = User::create([
                    'email' => strtolower($data['email']),
                    'password' => bcrypt($data['password']),
                ]);
                $user->roles()->sync($data['role_id']);

                unset($data['email']);
                unset($data['password']);
                unset($data['captcha']);
                unset($data['role_id']);
                unset($data['filepond']);

                $user->polsus()->create($data);
                DB::commit();
                $this->flashSuccess('Berhasil membuat akun!');

            return back();
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            dd($exception->getMessage());
            return back()->withInput();
        }
    }

    public function templateExcel($type)
    {
        $typeFileName = $type == 'anggota' ? 'Anggota' : 'Operator Polsus';
        return Excel::download(new TemplateLaporan($type), 'Template Input Data Akun Polsus - '.$typeFileName.'.xlsx');
    }

    public function importExcel(Request $request)
    {
        try {
            $this->__importExcel($request, 'register');
        } catch (\Exception $e) {
            $this->flashWarning($e->getMessage());
            return back();
        }

        $this->flashSuccess('Berhasil membuat akun polsus');
        return back();
    }

    public function updateDataPolsus(Request $request)
    {
        [$totalRows, $nipNotFound] = $this->__importExcel($request, 'update');
        $message = array_map(fn($nip) => 'Untuk No. NIP '.$nip.' tidak ditemukan!', $nipNotFound);

        if(! count($nipNotFound)) // jika no nip yang dimasukan valid semua
        {
            $this->flashSuccess('Berhasil mengupdate data akun polsus');
        }
        else if($totalRows == count($nipNotFound)) // jika semua no nip yang dimasukan tidak ada yang valid
        {
            array_push($message, 'Tidak ada data polsus yang diupdate!');

            $this->flashError(implode('<br>', $message));
        }
        else if($totalRows > count($nipNotFound)) // jika ada no nip yang tidak ditemukan namun hanya sebagian
        {
            array_push($message, 'Berhasil mengupdate data akun polsus');

            $this->flashWarning(implode('<br>', $message));
        }

        return back();
    }

    private function addFile($file)
    {
        $this->uploadPath = 'import/excel/polsus';
        $this->path_file = $this->saveFiles($file);
    }

    private function __importExcel(Request $request, $type)
    {
        $fileName = $type == 'register' ? 'file-laporan' : 'polsus-update-file';
        if($type == 'register') {
            $request->validate([
                'hak_akses' => ['required', 'exists:roles,id', 'array'],
                'file-laporan' => ['required', 'mimes:xlsx,xls']
            ]);
        } else {
            $request->validate([
                'polsus-update-file' => ['required', 'mimes:xlsx,xls']
            ]);
        }
        $this->addFile($request->file($fileName));

        $import = new RegisterPolsusImport($type == 'register' ? $request->hak_akses : [23], $type);
        Excel::import($import, $this->path_file  , $this->disk);

        if($type == 'update') { // jika action yang dilakukan adalah update data polsus, maka kembalikan nilai,,
            return [$import->getTotalRows(), $import->getNipNotFound()];
        }
    }
}
