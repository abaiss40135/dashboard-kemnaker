<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Services\Interfaces\KecamatanServiceInterface;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    protected $kecamatanService;

    /**
     * KecamatanController constructor.
     * @param KecamatanServiceInterface $kecamatanService
     */
    public function __construct(KecamatanServiceInterface $kecamatanService)
    {
        $this->kecamatanService = $kecamatanService;
    }

    public function getSelect2Data()
    {
        return $this->kecamatanService->getSelectData();
    }

    public function getName(Request $request)
    {
        $name = Kecamatan::where('code', $request->code)->pluck('name')->first();
        return response()->json($name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}