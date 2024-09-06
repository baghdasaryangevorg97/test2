<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;

class TaskDeadlineNotification extends Notification
{
    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->subject('Task Deadline Reminder')
                    ->line('Your task "' . $this->task->title . '" is due in one hour.')
                    ->line('Thank you for using our application!');
    }

    public function toBroadcast($notifiable)
    {
        //working onliny for websocket

        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'message' => 'Your task "' . $this->task->title . '" is due in one hour.'
        ]);
    }
}
