<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailTaskUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskUpdated  $event
     * @return void
     */
    public function handle(TaskUpdated $event)
    {
        //
    }
}
