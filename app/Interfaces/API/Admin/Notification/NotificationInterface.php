<?php

namespace App\Interfaces\API\Admin\Notification;

use Illuminate\Http\Request;

interface NotificationInterface
{
    public function getNotifications();
    public function setToReadNotification(int $id);
    public function newNotification(Request $request);
    public function destroyAllNotifications();
}
