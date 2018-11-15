<?php

namespace App\Events;

use App\Parameter;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ParameterSavingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $parameter;

    /**
     * Create a new event instance.
     *
     * @param Parameter $parameter
     */
    public function __construct(Parameter $parameter)
    {
        $this->parameter = $parameter;
    }

}
