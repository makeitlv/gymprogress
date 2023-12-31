<?php

declare(strict_types=1);

namespace App\Bus\Event;

use Illuminate\Bus\Dispatcher;

class EventBus implements EventBusInterface
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function dispatch(EventInterface $event): mixed
    {
        return $this->bus->dispatchToQueue($event);
    }
}
