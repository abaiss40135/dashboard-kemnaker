<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Services\Interfaces\KotaServiceInterface;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    protected $kotaService;

    /**
     * KotaController constructor.
     * @param KotaServiceInterface $kotaService
     */
    public function __construct(KotaServiceInterface $kotaService)
    {
        $this->kotaService = $kotaService;
    }

    public function getSelect2Data()
    {
        return $this->kotaService->getSelectData();
    }

    public function getName(Request $request)
    {
        $name = Kota::where('code', $request->code)->pluck('name')->first();
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
