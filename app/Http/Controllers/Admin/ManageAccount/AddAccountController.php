<?php

namespace App\Http\Controllers\Admin\ManageAccount;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PengelolaanAkun\StoreAccountRequest;
use App\Imports\BhabinImport;
use App\Models\Personel;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AddAccountController extends Controller
{
    private $path_file;
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    private function addFile($file){

        $this->uploadPath = 'import/excel/user';
        $this->path_file = $this->saveFiles($file);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.pengelolaan-akun.tambah-akun');
    }

    public function searchPersonel(Request $request){
        $request->validate([
            'nrp' => 'required|digits:8'
        ]);
        $arrayPersonel = ApiHelper::getBhabinByNrp($request->nrp);
        if (!is_array($arrayPersonel)){
            return $arrayPersonel;
        }
        $personel = Personel::find($arrayPersonel['personel_id']);

        return response(array_merge($arrayPersonel, ['role_id' => $personel ? $personel->user->getRole()->id : ""]));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAccountRequest $request)
    {
        $this->checkPermission('pengelolaan_akun_create');
        DB::beginTransaction();
        try {
            $this->userService->store($request->validated(), $request->role_id);
            DB::commit();
            $this->flashSuccess('berhasil menambahkan akun');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->flashError($e->getMessage());
        }
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importExcel(Request $request) {
        $request->validate([
            'hak_akses' => ['required', 'exists:roles,id', 'array'],
            'file'      => ['required', 'file']
        ]);
        if($request->hasFile('file')){
            $this->addFile($request->file('file'));
            Excel::import(new BhabinImport($request->hak_akses, $this->userService) , $this->path_file  , $this->disk);
            $this->flashSuccess('Impor berhasil');
        }
        return back();
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
