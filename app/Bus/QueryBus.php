<?php

declare(strict_types=1);

namespace App\Bus;

use App\Bus\QueryInterface;
use Illuminate\Bus\Dispatcher;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function ask(QueryInterface $query): mixed
    {
        return $this->bus->dispatch($query);
    }
}
