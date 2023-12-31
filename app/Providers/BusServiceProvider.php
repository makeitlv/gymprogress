<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\BusMapper;
use App\Bus\Command\CommandBus;
use App\Bus\Command\CommandBusInterface;
use App\Bus\Event\EventBus;
use App\Bus\Event\EventBusInterface;
use App\Bus\Query\QueryBus;
use App\Bus\Query\QueryBusInterface;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class BusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, function (
            Application $app,
            BusMapper $mapper,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            $bus->pipeThrough([]);
            $mapper->registerHandlers($bus);

            return new CommandBus($bus);
        });

        $this->app->singleton(EventBusInterface::class, function (
            Application $app,
            BusMapper $mapper,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            $bus->pipeThrough([]);
            $mapper->registerHandlers($bus);

            return new EventBus($bus);
        });

        $this->app->singleton(QueryBusInterface::class, function (
            Application $app,
            BusMapper $mapper,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            $mapper->registerHandlers($bus);

            return new QueryBus($bus);
        });

        $this->app->singleton(BusMapper::class);
    }
}
