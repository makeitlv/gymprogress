<?php

declare(strict_types=1);

namespace App\Bus;

use App\Bus\Command\CommandHandlerInterface;
use App\Bus\Command\CommandInterface;
use App\Bus\Event\EventHandlerInterface;
use App\Bus\Event\EventInterface;
use App\Bus\Query\QueryHandlerInterface;
use App\Bus\Query\QueryInterface;
use Illuminate\Bus\Dispatcher;
use Symfony\Component\Finder\Finder;
use ReflectionClass;
use ReflectionException;

final class BusMapper
{
    private const BASE_NAMESPACE = "Module";

    public function registerHandlers(Dispatcher $bus): void
    {
        $finder = new Finder();
        $finder
            ->in([
                base_path() . "/src/*/Application/UseCase/Query",
                base_path() . "/src/*/Application/UseCase/Event",
                base_path() . "/src/*/Application/UseCase/Command",
            ])
            ->files()
            ->name(["*.php"])
            ->contains(self::BASE_NAMESPACE);

        foreach ($finder as $file) {
            /** @var class-string|null $class */
            $class = $this->getClassFromFile($file->getRealPath());

            if ($class !== null) {
                $interfaces = class_implements($class);

                if ($interfaces === false) {
                    return;
                }

                foreach ($interfaces as $interface) {
                    switch ($interface) {
                        case CommandInterface::class:
                            $this->registerCommand($bus, $class);
                            break;
                        case QueryInterface::class:
                            $this->registerQuery($bus, $class);
                            break;
                        case EventInterface::class:
                            $this->registerEvent($bus, $class);
                            break;
                    }
                }
            }
        }
    }

    private function getClassFromFile(string $filePath): ?string
    {
        $namespace = $class = null;
        $contents = file_get_contents($filePath);

        if ($contents === false) {
            return null;
        }

        if (preg_match("/namespace\s+([^;]+);/", $contents, $matches)) {
            $namespace = $matches[1];
        }

        if (preg_match("/class\s+([^\s]+)\s+/i", $contents, $matches)) {
            $class = $matches[1];
        }

        if ($namespace && $class) {
            return $namespace . "\\" . $class;
        }

        return null;
    }

    /**
     *
     * @template T of object
     * @param class-string<T> $class
     */
    private function registerCommand(Dispatcher $bus, string $class): void
    {
        $handlerClass = $this->getHandlerClassName(
            $class,
            CommandHandlerInterface::class,
        );

        if ($handlerClass !== null) {
            $bus->map([$class => $handlerClass]);
        }
    }

    /**
     *
     * @template T of object
     * @param class-string<T> $class
     */
    private function registerQuery(Dispatcher $bus, string $class): void
    {
        $handlerClass = $this->getHandlerClassName(
            $class,
            QueryHandlerInterface::class,
        );

        if ($handlerClass !== null) {
            $bus->map([$class => $handlerClass]);
        }
    }

    /**
     *
     * @template T of object
     * @param class-string<T> $class
     */
    private function registerEvent(Dispatcher $bus, string $class): void
    {
        $handlerClass = $this->getHandlerClassName(
            $class,
            EventHandlerInterface::class,
        );

        if ($handlerClass !== null) {
            $bus->map([$class => $handlerClass]);
        }
    }

    /**
     *
     * @template T of object
     * @param class-string<T> $messageClass
     */
    private function getHandlerClassName(
        string $messageClass,
        string $handlerInterface,
    ): ?string {
        try {
            $reflectionClass = new ReflectionClass($messageClass);

            foreach ($reflectionClass->getInterfaces() as $interface) {
                if (
                    in_array(
                        $handlerInterface,
                        class_implements($interface->getName()),
                    )
                ) {
                    return $interface->getName();
                }
            }
        } catch (ReflectionException $e) {
        }

        return null;
    }
}
