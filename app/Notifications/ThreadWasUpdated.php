<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{

    protected $thread;
    protected $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path()
        ];
    }
}
