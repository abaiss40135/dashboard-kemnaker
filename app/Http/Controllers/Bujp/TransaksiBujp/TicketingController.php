<?php

namespace App\Http\Controllers\Bujp\TransaksiBujp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\TransaksiBujp\StoreTicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;

final class TicketingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return TicketService::getDatatable();
        }

        return view('bujp.transaksi-bujp.ticket', [
            'status' => Ticket::STATUS
        ]);
    }

    public function store(StoreTicketRequest $request) {
        try {
            $data = $request->validated();
            (new TicketService())->store($data);

            $this->flashSuccess('Berhasil membuat tiket kendala perizinan');
        } catch (\Exception $err) {
            $this->flashError($err->getMessage());            
        }

        return back();
    }
}
