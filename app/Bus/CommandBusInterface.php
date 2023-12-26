<?php

declare(strict_types=1);

namespace App\Bus;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
