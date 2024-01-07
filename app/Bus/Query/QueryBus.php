<?php

declare(strict_types=1);

namespace App\Bus\Query;

use App\Bus\Query\QueryInterface;
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
