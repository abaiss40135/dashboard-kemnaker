<?php

namespace App\Events;

use App\Models\Paparan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaparanAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Paparan $paparan)
    {
        $message = strlen($paparan->nama_paparan) > 50 ? substr($paparan->nama_paparan, 0, 50) . '...' : $paparan->nama_paparan;

        $this->data['title'] = 'Konten Informasi | Paparan Baru';
        $this->data['message'] = $message;
        $this->data['image'] = $paparan->url_thumbnail;
        $this->data['action'] =  '/pusat-informasi?fill_input=paparan&search_value=' . substr($paparan->nama_paparan, 0, 30);
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
