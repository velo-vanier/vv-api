# Build stage
FROM vv-api-fpm as build

RUN apt-get update \
  && apt-get install -yqq ssh git zip curl vim \
	&& rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

COPY . /var/www/app

RUN cd /var/www/app \
  && composer install --no-dev --no-interaction --no-progress

RUN chown -R www-data /var/www/app

VOLUME ["/var/www/app"]
