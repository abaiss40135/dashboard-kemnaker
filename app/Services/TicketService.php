<?php

namespace App\Services;

use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Http\Traits\FileUploadTrait;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TicketService
{
    use FileUploadTrait;

    public function store(array $data)
    {
        $data['user_id']  = auth()->user()->id;
        $data['status']   = $data['status'] ?? 0;

        $this->uploadPath = 'bujp_ticketing';
        $this->folderName = $data['id_izin'];
        $this->fileName   = Str::slug($data['file']->getClientOriginalName())
                            .now()->format('Ymd_His').'.'.$data['file']->getClientOriginalExtension();

        $ticket           = Ticket::create($data);
        $ticket['file']   = $this->saveFiles($data['file']);
        $ticket->save();

        TicketCreated::dispatch($ticket);
    }

    public static function getDatatable(): \Illuminate\Http\JsonResponse
    {
        $id_izin = request()->id_izin;
        $status  = request()->status;
        $s_date  = request()->start_date;
        $e_date  = request()->end_date;
        $auth    = auth()->user();

        $query = Ticket::query()
            ->when(isset($id_izin), fn ($q) => $q->where('id_izin', $id_izin))
            ->when(isset($status),  fn ($q) => $q->where('status', $status))
            ->when(isset($s_date),  fn ($q) => $q->where('created_at', '>=', $s_date))
            ->when(isset($e_date),  fn ($q) => $q->where('created_at', '<=', $e_date))
            ->when($auth->haveRoleID([1]), fn ($q) => $q->with('user.bujp'))
            ->when($auth->haveRoleID([6]), fn ($q) => $q->where('user_id', $auth->id))
            ->with('latest_comment');

        return Datatables::eloquent($query)
            ->editColumn('status', fn ($row) => sprintf(
                '<span class="badge badge-%s">%s</span>',
                Ticket::STATUS[$row->status]['color'],
                Ticket::STATUS[$row->status]['text']
            ))
            ->editColumn('created_at', fn ($row) => (
                $row->created_at->translatedFormat(config('app.long_datetime_format'))
            ))
            ->editColumn('updated_at', fn ($row) => (
                $row->updated_at->translatedFormat(config('app.long_datetime_format'))
            ))
            ->editColumn('file', fn ($row) => (
                $row->file ? config('filesystems.storage_url').preg_replace('/\/\//', '/', $row->file) : ''
            ))
            ->addColumn('file_comment', function ($row) {
                $button = empty($row->file) ? '' : '<a href="'.$row->file_url.'"
                    class="btn btn-primary mb-1"
                    title="lihat screenshot">
                    <i class="fas fa-eye"></i>
                </a>';

                if (!empty($row->latest_comment) && !auth()->user()->haveRoleID(User::BUJP) && $row->latest_comment->user->haveRoleID(User::BUJP)) {
                    $button .= '<button data-id="'.$row->id.'"
                        class="btn btn-danger"
                        title="Ada komentar yang yang belum dibalas"
                        data-toggle="modal"
                        data-target="#modal-komentar">
                        <i class="fa fa-comment-alt"></i>
                    </button>';
                } else {
                    $button .= '<button data-id="'.$row->id.'"
                        class="btn btn-primary"
                        title="lihat komentar"
                        data-toggle="modal"
                        data-target="#modal-komentar">
                        <i class="fa fa-comment-alt"></i>
                    </button>';
                }

                return $button;
            })
            ->rawColumns(['status', 'file_comment'])
            ->toJson();        
    }

    public static function show(int|String $id)
    {
        return Ticket::find($id);
    }

    public static function update(int|String $id, array $data)
    {
        $ticket                     = self::show($id);
        $ticket['hasil_pengecekan'] = $data['hasil_pengecekan'];
        $ticket['penanganan']       = $data['penanganan'];
        $ticket['status']           = $data['status'];
        $ticket->save();

        TicketUpdated::dispatch($ticket);
    }
}