<?php

declare(strict_types=1);

namespace App\Bus\Event;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): mixed;
}
