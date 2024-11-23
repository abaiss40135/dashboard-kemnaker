<?php

namespace App\Http\Controllers\Admin\MasterBujp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\SuratIzinOperasional\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;

final class TicketingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return (new TicketService())->getDatatable();
        }

        return view('administrator.bujp-satpam.ticket', [
            'status' => Ticket::STATUS
        ]);
    }

    public function show($id) {
        try {
            return TicketService::show($id);
        } catch (\Exception $err) {
            return $err->getMessage();
        }
    }

    public function update($id, UpdateTicketRequest $request)
    {
        try {
            $data = $request->validated();
            TicketService::update($id, $data);

            $this->flashSuccess('Berhasil memperbarui tiket kendala perizinan');
        } catch (\Exception $err) {
            $this->flashError($err->getMessage());            
        }

        return back();
    }
}