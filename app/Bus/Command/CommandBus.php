<?php

declare(strict_types=1);

namespace App\Bus\Command;

use Illuminate\Bus\Dispatcher;

class CommandBus implements CommandBusInterface
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function dispatch(CommandInterface $command): mixed
    {
        return $this->bus->dispatch($command);
    }
}
