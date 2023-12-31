<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\CommandBusInterface;
use App\Bus\EventBus;
use App\Bus\EventBusInterface;
use App\Bus\QueryBus;
use App\Bus\QueryBusInterface;
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
            /** TODO: создать сервис который будет автоматом регестрировать команды с обработчиками */
            $bus->map([]);

            return new CommandBus($bus);
        });

        $this->app->singleton(EventBusInterface::class, function (
            Application $app,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            $bus->pipeThrough([]);
            /** TODO: создать сервис который будет автоматом регестрировать команды с обработчиками */
            $bus->map([]);

            return new EventBus($bus);
        });

        $this->app->singleton(QueryBusInterface::class, function (
            Application $app,
        ) {
            /** @var Dispatcher $bus */
            $bus = $app->make(Dispatcher::class);

            /** TODO: создать сервис который будет автоматом регестрировать команды с обработчиками */
            $bus->map([]);

            return new QueryBus($bus);
        });
    }
}
