#syntax=docker/dockerfile:1.4

FROM dunglas/frankenphp:latest-php8.3-alpine AS frankenphp
FROM composer/composer:2.5.8-bin AS composer

FROM frankenphp AS base

WORKDIR /app

# hadolint ignore=DL3018
RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
	;

RUN set -eux; \
	install-php-extensions \
		apcu \
		intl \
		opcache \
		zip \
	;

COPY --link docker/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY --link --chmod=755 docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY --link docker/Caddyfile /etc/caddy/Caddyfile

ENTRYPOINT ["docker-entrypoint"]

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY --from=composer --link /composer /usr/bin/composer

HEALTHCHECK --start-period=60s CMD curl -f http://localhost:2019/metrics || exit 1
CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]

FROM base as dev

ENV APP_ENV=dev XDEBUG_MODE=off

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
		xdebug \
	;

COPY --link docker/conf.d/app.dev.ini $PHP_INI_DIR/conf.d/

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--watch" ]

FROM base AS prod

ENV APP_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --link docker/conf.d/app.prod.ini $PHP_INI_DIR/conf.d/

# Prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* ./
RUN set -eux; \
	composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress

COPY --link . ./
RUN rm -Rf docker/

RUN set -eux; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	chmod +x artisan; sync;
