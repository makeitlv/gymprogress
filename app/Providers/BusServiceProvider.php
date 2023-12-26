<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\CommandBusInterface;
use App\Bus\QueryBus;
use App\Bus\QueryBusInterface;
use Fruitcake\TelescopeToolbar\Toolbar;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class BusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, function (
            Application $app,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);
            $bus->pipeThrough([]);

            return new CommandBus($bus);
        });

        $this->app->singleton(QueryBusInterface::class, function (
            Application $app,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            return new QueryBus($bus);
        });
    }
}
