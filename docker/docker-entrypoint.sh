#!/bin/sh
set -e

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

	if grep -q ^DB_CONNECTION= .env; then
		echo "Waiting for database to be ready..."
		ATTEMPTS_LEFT_TO_REACH_DATABASE=60

		until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php artisan db:monitor 2>&1); do
			if [ $? -eq 0 ]; then
				break
			fi

			sleep 1
			ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
			echo "Still waiting for database to be ready... $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left."
		done

		if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
			echo "The database is not up or not reachable."
			echo "$DATABASE_ERROR"
			exit 1
		else
			echo "The database is now ready and reachable."
		fi

		if [ "$(find ./database/migrations -name '*.php' -print -quit)" ]; then
			php artisan migrate --force
		fi
	fi

	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX storage
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX storage

	if [ "$APP_ENV" != "prod" ]; then
		chown 1000:1000 -R ./
	fi
fi

exec docker-php-entrypoint "$@"
