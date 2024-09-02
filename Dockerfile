FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /app
COPY . /app
RUN chmod +x /app/docker/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["sh", "/app/docker/entrypoint.sh"]
