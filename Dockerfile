# Base image for PHP environment
FROM php:8.3 as php

# Install dependencies
ENV ACCEPT_EULA=Y
RUN apt-get update && apt-get install -y gnupg2
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get -y --no-install-recommends install msodbcsql17 unixodbc-dev
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv

# Create app directory
WORKDIR /var/www

# Copy project files
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENTRYPOINT [ "./entrypoint.sh" ]
