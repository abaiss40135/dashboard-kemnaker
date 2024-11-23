<?php

namespace App\Events;

use App\Models\Infografis;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InfografisAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Infografis $infografis)
    {
        $this->data['title'] = 'Konten Informasi | Infografis Baru';
        $this->data['message'] = $infografis->judul;
        $this->data['image'] = '';
        $this->data['action'] =  '/pusat-informasi?fill_input=infografis&search_value=' . $infografis->judul;
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
