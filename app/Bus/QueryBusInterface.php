<?php

declare(strict_types=1);

namespace App\Bus;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
