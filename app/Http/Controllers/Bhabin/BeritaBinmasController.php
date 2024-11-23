<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\BeritaServiceInterface;
use Illuminate\Http\Request;

class BeritaBinmasController extends Controller
{
    protected $beritaBinmasService;

    /**
     * BeritaBinmasController constructor.
     * @param BeritaServiceInterface $beritaBinmasService
     */
    public function __construct(BeritaServiceInterface $beritaBinmasService)
    {
        $this->beritaBinmasService = $beritaBinmasService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->beritaBinmasService->getBeritaBinmas();
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        $berita = $this->beritaBinmasService->show($id);
        return view('bhabin.berita.berita' , ['data' => $berita]);
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
