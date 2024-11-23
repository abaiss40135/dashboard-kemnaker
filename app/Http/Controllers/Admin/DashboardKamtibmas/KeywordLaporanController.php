<?php

namespace App\Http\Controllers\Admin\DashboardKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Keyword\UpdateKeywordRequest;
use App\Models\Keyword;
use App\Services\Interfaces\KeywordServiceInterface;
use Illuminate\Http\Request;

class KeywordLaporanController extends Controller
{
    /**
     * @var KeywordServiceInterface
     */
    private $keywordService;

    public function __construct(KeywordServiceInterface $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    public function datatable()
    {
        return $this->keywordService->getDatatable();
    }

    public function index()
    {
        return view('administrator.dashboard.trending-keyword.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Keyword $keywordLaporan)
    {
        //
    }

    public function edit(Keyword $keywordLaporan)
    {
        //
    }

    public function update(UpdateKeywordRequest $request, Keyword $keywordLaporan)
    {
        try {
            $this->keywordService->update($request->validated(), $keywordLaporan);
            return $this->responseSuccess([
                'message' => 'Keyword berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy(Keyword $keywordLaporan)
    {
        //
    }
}
