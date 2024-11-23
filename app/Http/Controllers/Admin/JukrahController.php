<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Jukrah\StoreJukrahRequest;
use App\Http\Requests\Administrator\Jukrah\UpdateJukrahRequest;
use App\Models\Jukrah;
use App\Services\JukrahService;
use Illuminate\Http\Request;

class JukrahController extends Controller
{
    private $jukrahService;

    public function __construct()
    {
        $this->jukrahService = new JukrahService();
    }

    public function index()
    {
        $this->checkPermission('jukrah_access');
        if (in_array(request()->get('type'), Jukrah::TYPE)) {
            return view('administrator.jukrah.index', ['title' => strtoupper(str_replace('_', ' ', request()->get('type')))]);
        } else {
            abort(404);
        }
    }

    public function getDatatable(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);
        return $this->jukrahService->getDatatable();
    }


    public function store(StoreJukrahRequest $request)
    {
        $this->checkPermission('jukrah_create');

        try {
            $this->jukrahService->store($request->validated());
            return $this->responseSuccess([
                'message' => 'Jukrah berhasil ditambahkan'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    public function show($id)
    {
        return $this->jukrahService->show($id);
    }

    public function update(UpdateJukrahRequest $request, $id)
    {
        $this->checkPermission('jukrah_edit');
        try {
            $this->jukrahService->update($request->validated(), $id);
            return $this->responseSuccess([
                'message' => 'Jukrah berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        $this->checkPermission('jukrah_destroy');

        try {
            $this->jukrahService->delete($id);
            return $this->responseSuccess([
                'message' => 'Jukrah berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }
}
