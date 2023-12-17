# Laravel Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Laravel]](https://laravel.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/makeitlv/laravel-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

-   Production, development and CI ready
-   Just 1 service by default
-   Automatic HTTPS (in dev and prod)
-   Native [XDebug](docs/xdebug.md) integration
-   Super-readable configuration

**Enjoy!**

## License

Laravel Docker is available under the MIT License.

## Credits

Inspired and based to work of [Symfony Docker](https://github.com/dunglas/symfony-docker) by [Kévin Dunglas](https://github.com/dunglas)
