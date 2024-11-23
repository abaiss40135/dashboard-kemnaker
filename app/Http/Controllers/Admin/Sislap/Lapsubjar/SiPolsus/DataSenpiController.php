<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus;

use App\Exports\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataSenpi;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DataSenpiController extends Controller
{
    protected $model = DataSenpi::class;
    private $service;

    public function __construct()
    {
        $this->service = new DataSenpiAmunisiService($this->model);
    }

    public function index() {
        return view('administrator.sislap.lapsubjar.si-polsus.data-senpi.index', [
            'model' => addcslashes($this->model, "\\"),
            "polices" => $this->service->polices,
            "attributes" => $this->service->attributes
        ]);
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
     * @param  \Illuminate\Http\DataSenpiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataSenpiAmunisiRequest $request)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function exportExcel() {
        $template = new TemplateLaporan($this->model);
        return Excel::download($template, 'Laporan Data Senpi Polsus - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function search(Request $request) {
        $data = $this->service->search($request);

        return response()->json([
            "data" => $data,
            "from" => 1,
            "total" => count($data)
        ]);
    }
}
