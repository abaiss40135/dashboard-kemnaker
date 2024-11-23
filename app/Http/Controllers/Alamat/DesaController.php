<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Services\Interfaces\DesaServiceInterface;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    protected $desaService;

    /**
     * DesaController constructor.
     * @param DesaServiceInterface $desaService
     */
    public function __construct(DesaServiceInterface $desaService)
    {
        $this->desaService = $desaService;
    }

    public function getSelect2Data()
    {
        return $this->desaService->getSelectData();
    }

    public function getName(Request $request)
    {
        $name = Desa::where('code', $request->code)->pluck('name')->first();
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
