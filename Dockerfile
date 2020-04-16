FROM php:7.4-cli

ENV PORT ${PORT}

# Install Postgre PDO
# Install modules
RUN apt-get update && apt-get install -y \
        libpq-dev \
                --no-install-recommends
RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY . /app
WORKDIR /app

RUN composer install

ENV PHINX_DB_USER ${DB_USER}
ENV PHINX_DB_PASSWORD ${DB_PASSWORD}
ENV PHINX_DB_NAME ${DB_NAME}
ENV PHINX_DB_HOST ${DB_HOST}
ENV PHINX_DB_PORT ${DB_PORT}

ENTRYPOINT ./vendor/bin/phinx migrate && php /app/src/app.php