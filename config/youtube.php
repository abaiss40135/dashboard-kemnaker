<?php

/*
|--------------------------------------------------------------------------
| Laravel PHP Facade/Wrapper for the Youtube Data API v3
|--------------------------------------------------------------------------
|
| Here is where you can set your key for Youtube API. In case you do not
| have it, it can be acquired from: https://console.developers.google.com
*/

return [
    'key' => env('YOUTUBE_API_KEY', 'YOUR_API_KEY'),
    'playlist_id' => [
        'trending_indonesia' => 'PLEdYu6OEZHwdyUYgO_GNAi-P9T1TN9mHC'
    ]
];
