FROM php:7.4-cli

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY . /app
WORKDIR /app

RUN composer install

CMD ["php", "app.php"]