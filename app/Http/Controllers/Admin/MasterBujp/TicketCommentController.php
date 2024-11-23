<?php

namespace App\Http\Controllers\Admin\MasterBujp;

use App\Events\TicketCommentCreated;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class TicketCommentController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'ticket_id' => 'required|numeric|exists:tickets,id',
            'comment'   => 'required|max:255'
        ]);

        $data['user_id'] = auth()->user()->id;

        try {
            DB::transaction(function () use ($data) {
                Comment::create($data);
            });

            $ticket = Ticket::with('comments.user.roles')->find($data['ticket_id']);
            if (auth()->user()->id !== $ticket->user_id) {
                TicketCommentCreated::dispatch($ticket);
            }

            return response()->json($ticket, 200);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    public function show($id)
    {
        $ticket = Ticket::with('comments.user.roles')->find($id);

        try {
            if (!$ticket) {
                throw new \Exception('Ticket tidak ditemukan');
            }
            return response()->json($ticket, 200);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }
}