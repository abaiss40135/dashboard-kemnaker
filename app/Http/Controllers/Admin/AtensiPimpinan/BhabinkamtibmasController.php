<?php

namespace App\Http\Controllers\Admin\AtensiPimpinan;

use App\Http\Controllers\Controller;
use App\Services\AtensiPimpinanService;
use App\Services\Interfaces\AtensiPimpinanServiceInterface;
use Illuminate\Http\Request;

class BhabinkamtibmasController extends Controller
{
    private $atensiPimpinanService;

    /**
     * BhabinkamtibmasController constructor.
     * @param AtensiPimpinanServiceInterface $atensiPimpinanService
     */
    public function __construct(AtensiPimpinanServiceInterface $atensiPimpinanService)
    {
        $this->atensiPimpinanService = $atensiPimpinanService;
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
