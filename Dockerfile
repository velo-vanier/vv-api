FROM webdevops/php-nginx

RUN \
	export PHP_INSTALL_DEPS="libmcrypt-dev libicu-dev wget php-mysql php-intl php-mbstring" \
	&& apt-get update \
	&& apt-get install -y ${PHP_INSTALL_DEPS}

COPY docker/nginx/site.conf /opt/docker/etc/nginx/conf.d/site.conf

ADD . /var/www/app

# set write permissions on the log directories
RUN chmod a+w -R /var/www/app/storage/

# set up the production environment
RUN cp /var/www/app/.env.example /var/www/app/.env
RUN cd /var/www/app && sed -i 's/APP_ENV=local/APP_ENV=production/g' .env \
	&& sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env

# install composer packages
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /var/www/app/composer
RUN cd /var/www/app && ./composer install

# generate application key
RUN cd /var/www/app && php artisan key:generate