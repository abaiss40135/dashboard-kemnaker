<?php

namespace App\Notifications;

use App\Models\AtensiPimpinan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AtensiPimpinanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var AtensiPimpinan
     */
    private $atensiPimpinan;

    protected $description = 'Atensi dari Pimpinan';

    public function __construct(AtensiPimpinan $atensiPimpinan)
    {
        $this->atensiPimpinan = $atensiPimpinan;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return $this->atensiPimpinan->toArray();
    }
}
