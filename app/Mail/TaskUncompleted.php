<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskUncompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $task;

    /**
     * TaskUncompleted constructor.
     * @param $user
     * @param $task
     */
    public function __construct($user, $task)
    {
        $this->user = $user;
        $this->task = $task;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.tasks.uncompleted');
    }
}
