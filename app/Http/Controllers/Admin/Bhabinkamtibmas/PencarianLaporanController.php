<?php

namespace App\Http\Controllers\Admin\Bhabinkamtibmas;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Http\Request;

class PencarianLaporanController extends Controller
{
    private $keywordService;

    /**
     * PencarianLaporanController constructor.
     * @param $pencarianLaporanService
     */
    public function __construct(KeywordServiceInterface $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return $this->keywordService->getPencarianLaporan();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSelectedPathRegionMap()
    {
        return $this->keywordService->getSelectedRegionMap();
    }

    public function getPopularKeyword()
    {
        return $this->keywordService->getPopularKeyword();
    }

    /**
     * @param $province
     * @return \Illuminate\Support\Collection
     */
    public function getPopularKeywordByProvince($province)
    {
        return $this->keywordService->getPopularKeywordByProvince($province);
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
