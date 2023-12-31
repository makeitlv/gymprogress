<?php

declare(strict_types=1);

namespace App\Bus\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
