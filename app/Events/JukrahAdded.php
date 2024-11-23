<?php

namespace App\Events;

use App\Models\Jukrah;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JukrahAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Jukrah $jukrah)
    {
        $this->data['title'] = 'Konten Informasi | Jukrah Baru';
        $this->data['message'] = $jukrah->nama;
        $this->data['image'] = '';
        $this->data['action'] =  '/jukrah-bhabin?fill_input=jukrah&search_value=' . $jukrah->nama;

        // apakah jukrah ditunjukan untuk bhabinkamtibmas atau bukan, jika bukan maka arahkan ke public
        $this->data['sendToUserId'] = $jukrah->type == 'bhabinkamtibmas' ? [User::BHABIN] : [User::PUBLIK];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
