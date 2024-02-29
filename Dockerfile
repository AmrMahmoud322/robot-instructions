# Use the official PHP image
FROM php:8.1-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the local files to the container
COPY . .

# Install necessary PHP extensions and dependencies
RUN docker-php-ext-install pdo_mysql

# Enable Apache module
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80 for Apache
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
