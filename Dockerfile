FROM php:8.0-fpm

# Instala as extensões necessárias para o PHP e dependências adicionais
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo_sqlite

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala o PHPUnit globalmente
RUN composer global require phpunit/phpunit ^9.0

# Adiciona o Composer global ao PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Configura o PHP-FPM para usar o Nginx
RUN echo "cgi.fix_pathinfo=0" >> /usr/local/etc/php/conf.d/docker-php.ini

# Configura o diretório de trabalho
WORKDIR /var/www/html
