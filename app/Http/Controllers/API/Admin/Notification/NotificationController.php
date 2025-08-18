<?php

namespace App\Http\Controllers\API\Admin\Notification;

use App\Http\Controllers\Controller;
use App\Services\API\Admin\Notification\NotificationService;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getNotifications()
    {
        return $this->notificationService->getNotifications();
    }

    public function setToReadNotification(int $id)
    {
        return $this->notificationService->setToReadNotification($id);
    }

    public function newNotification(Request $request)
    {
        return $this->notificationService->newNotification($request);
    }

    public function destroyAllNotifications()
    {
        return $this->notificationService->destroyAllNotifications();
    }
}
