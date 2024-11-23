<?php

namespace App\Http\Controllers\API;

use Alaouy\Youtube\Facades\Youtube;
use App\Http\Controllers\Controller;

class YoutubeController extends Controller
{
    public function getTrendingIndonesia()
    {
        // $trendings = Youtube::getPlaylistItemsByPlaylistId(config('youtube.playlist_id.trending_indonesia'), '', 30)['results'];
        $trendings = Youtube::getPopularVideos('id');
        return collect($trendings)->map(function ($item, $key) {
            return [
                'thumbnail' => $item->snippet->thumbnails->medium->url,
                'title'     => $item->snippet->title,
                // 'owner'     => $item->snippet->videoOwnerChannelTitle,
                'owner'     => $item->snippet->channelTitle,
                // 'url'       => 'https://youtube.com/watch?v=' . $item->contentDetails->videoId
                'url'       => 'https://youtube.com/watch?v=' . $item->id
            ];
        });
    }
}
