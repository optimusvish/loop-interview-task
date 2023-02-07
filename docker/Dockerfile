# Use the official Ubuntu 20.04 base image
FROM ubuntu:20.04

# Set environment variables
ENV DEBIAN_FRONTEND noninteractive

# Set TimeZone
ENV TZ Asia/Kolkata

USER root

# Update package index and install Apache2, PHP 8 and MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    && apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.0 && \
    apt-get install -y libapache2-mod-php8.0 && \
    apt-get install -y mysql-server && \
    apt-get install -y php8.0-mysql && \
    apt-get install -y php8.0-zip && \
    apt-get install -y php8.0-xml && \
    apt-get install -y php8.0-curl &&\
    apt-get install -y php8.0-mbstring && \
    apt-get clean

# Copy Apache2 configuration file
COPY docker/apache2.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache2
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Copy your Laravel application files into the Docker container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install

# Generate the Laravel application key
RUN php artisan key:generate

# Copy the products.csv to storage app
COPY postman_collection/products.csv /var/www/html/storage/app/public/

# Copy the customers.csv to storage app
COPY postman_collection/customers.csv /var/www/html/storage/app/public/

# Expose Apache2 port
EXPOSE 80

# Start Apache2 service
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

# Set the script file as executable
# RUN chmod a+x /var/www/html/docker/artisan_script.sh

# # Run the script during container creation
# RUN /var/www/html/docker/artisan_script.sh
