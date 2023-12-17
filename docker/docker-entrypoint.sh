#!/bin/sh
set -e

#TODO: 1. Database
if [ "$1" = 'frankenphp' ] || [ "$1" = 'php' ] || [ "$1" = 'artisan' ]; then
	if [ ! -f composer.json ]; then
		rm -Rf tmp/
		composer create-project "laravel/laravel $LARAVEL_VERSION" tmp --stability="$STABILITY" --prefer-dist --no-progress --no-interaction --no-install --no-scripts

		cd tmp
		cp -Rp . ..
		cd -
		rm -Rf tmp/

		composer run-script post-root-package-install
		composer install --prefer-dist --no-progress --no-interaction
		composer run-script post-create-project-cmd

		composer require "php:>=$PHP_VERSION" laragear/preload

		php artisan preload:placeholder
	fi

	if [ -z "$(ls -A 'vendor/' 2>/dev/null)" ]; then
		composer install --prefer-dist --no-progress --no-interaction
	fi

	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX storage
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX storage

	if [ "$APP_ENV" != "prod" ]; then
		chown "$(whoami)":"$(whoami)" -R ./
	fi
fi

exec docker-php-entrypoint "$@"
