<?php

namespace App\Events;

use App\Models\Meme;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemeAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meme $meme)
    {
        $message = strlen($meme->caption) > 80 ? substr($meme->caption, 0, 80) . '...' : $meme->caption;

        $this->data['title'] = $meme->nama_meme;
        $this->data['message'] = $message;
        $this->data['image'] = $meme->url_gambar;
        $this->data['action'] =  '/pusat-informasi?fill_input=meme&search_value=' . substr($meme->caption, 0, 30);
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
