<?php

namespace App\Http\Controllers\API\LaravelFcm;

use App\Events\InfografisAdded;
use App\Events\JukrahAdded;
use App\Events\MemeAdded;
use App\Events\PaparanAdded;
use App\Events\VideoAdded;
use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\Jukrah;
use App\Models\Meme;
use App\Models\Paparan;
use App\Models\User;
use App\Models\VideoLanding;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function testPushNotif($title = '', $message = '')
    {
        $jukrah = Jukrah::first();
        event(new JukrahAdded($jukrah));

        return $this->responseSuccess([
            'status' => 'success',
            'message' => 'berhasil mengirim notifikasi ke seluruh subscribes user'
        ]);
    }
}
