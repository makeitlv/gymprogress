#!/bin/bash

if [ $# -gt 0 ]; then
	if [ "$1" == "php" ]; then
		shift 1
		docker-compose exec php php "$@"
		docker-compose exec php chown -R $(id -u):$(id -g) .
	elif [ "$1" == "composer" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 /usr/bin/composer "$@"
	elif [ "$1" == "npm" ]; then
		shift 1
		docker run -it --rm -v "$PWD":/usr/src/app -w /usr/src/app node:21-bullseye npm "$@"
		docker-compose exec php chown -R $(id -u):$(id -g) .
	elif [ "$1" == "fixperm" ]; then
		shift 1
		docker-compose exec php chown -R $(id -u):$(id -g) .
	elif [ "$1" == "fix" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/phpcbf
	elif [ "$1" == "phpcs" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/phpcs --standard=phpcs.xml
	elif [ "$1" == "phpstan" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/phpstan
	elif [ "$1" == "deptrac" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/deptrac analyse
	elif [ "$1" == "qa" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/phpcs --standard=phpcs.xml
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/phpstan
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/deptrac analyse
	elif [ "$1" == "test" ]; then
		shift 1
		docker-compose exec php php -d memory_limit=-1 ./vendor/bin/pest "$@"
	else
		echo "Unknown command"
	fi
else
	echo "Unknown command"
fi