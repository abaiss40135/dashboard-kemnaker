<?php

namespace App\Events;

use App\Models\VideoLanding;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VideoLanding $video)
    {
        $message = strlen($video->judul_video) > 75 ? substr($video->judul_video, 0, 75) . '...' : $video->judul_video;

        $this->data['title'] = "Konten Informasi | Video Baru!";
        $this->data['message'] = $message;
        $this->data['image'] = '';
        $this->data['action'] =  '/pusat-informasi?fill_input=video&search_value=' . substr($video->judul_video, 0, 30);
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
