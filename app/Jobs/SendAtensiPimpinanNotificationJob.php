<?php

namespace App\Jobs;

use App\Models\AtensiPimpinan;
use App\Models\User;
use App\Notifications\AtensiPimpinanNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendAtensiPimpinanNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AtensiPimpinan
     */
    private $atensiPimpinan;

    public function __construct(AtensiPimpinan $atensiPimpinan)
    {
        $this->atensiPimpinan = $atensiPimpinan;
    }

    public function handle()
    {
        $usersQuery = User::query();
        switch ($this->atensiPimpinan->sasaran){
            case 'bhabinkamtibmas':
                $usersQuery->isBhabinkamtibmas();
                break;
            case 'satpam':
                $usersQuery->isSatpam();
                break;
            case 'publik':
                $usersQuery->isPublik();
                break;
        }
        $usersQuery->select('id')->chunk(100, function ($users){
            Notification::send($users, new AtensiPimpinanNotification($this->atensiPimpinan));
            sleep(10);
        });
    }
}
