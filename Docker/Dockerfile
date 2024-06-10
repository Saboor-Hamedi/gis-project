FROM php:8.2-apache
WORKDIR /var/www/html
# Copy the content of the local Docker directory to the working directory
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./mysql-config.cnf /etc/mysql/mysql.conf.d/

# Enable Apache modules and configurations
# Enable Apache modules and configurations
RUN a2enmod rewrite

# Install PHP extensions and additional software
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl pdo pdo_mysql pdo_pgsql mysqli zip

# Expose port 80 for HTTP and 443 for HTTPS
EXPOSE 80
EXPOSE 443

# Start Apache
CMD ["apache2-foreground"]
