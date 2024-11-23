<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewKontenInformasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendNotificationNewInformationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected const SEND_TO_USER_ID = [
        User::BHABIN, User::SATPAM, User::PUBLIK, User::POLSUS
    ];


    public $title;
    public $message;
    public $image;
    public $action;
    public $sendToUserId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->title = $data['title'];
        $this->message = $data['message'];
        $this->image = $data['image'];
        $this->action = $data['action'];
        $this->sendToUserId = array_key_exists('sendToUserId', $data)
            ? $data['sendToUserId'] : self::SEND_TO_USER_ID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = new NewKontenInformasi($this->title, $this->message, $this->image, $this->action);

//    Notification::route('fcm', 'cFSgD6L7kiobSoa5XKh2KG:APA91bHKmd9qynLfwf0Ojln5NU6UwfEAQU2ENThVXMIAqn3IY1YlDTgZQ9bLCMMp-2GunDra27W0gbRdml1gsr_ZsUYiEjxvMr0kFlZF9H4J5C_1mEvQe8IdcPTSZlVM0MwZvS6LgNM9')
//        ->notify($notification);

//        chunk every 100 users
        User::select('fcm_key')->whereHas('roles', function($q) {
            $q->whereIn('id', $this->sendToUserId);
        })->whereNotNull('fcm_key')->chunk(100, function($users) use ($notification) {
            foreach($users as $user) {
                try {
                    Notification::route('fcm', $user->fcm_key)
                        ->notify($notification);
                } catch (\Exception $e) {
                    DB::table('failed_jobs')->insert([
                        'connection' => 'database',
                        'queue' => 'default',
                        'payload' => json_encode([
                            'displayName' => 'App\Notifications\NewKontenInformasi',
                            'job' => 'Illuminate\Notifications\SendQueuedNotifications',
                            'maxTries' => null,
                            'maxExceptions' => null,
                            'backoff' => null,
                            'timeout' => null,
                            'retryUntil' => null,
                            'data' => [
                                'notification' => $notification,
                                'notifiables' => [
                                    [
                                        'id' => $user->id,
                                        'type' => 'App\Models\User',
                                        'routeNotificationForFcm' => $user->fcm_key,
                                    ]
                                ]
                            ]
                        ]),
                        'exception' => $e->getMessage(),
                        'failed_at' => now()
                    ]);
                }
            }
        });
    }
}
