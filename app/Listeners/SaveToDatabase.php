<?php

namespace App\Listeners;

use App\Events\AdminNotification;
use App\Models\AdminNotification as ModelsAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveToDatabase
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AdminNotification $event): void
    {
        // ModelsAdminNotification::create([
        //     'description' => $event->message
        // ]);
    }
}
