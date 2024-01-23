# Use the official PHP image with Apache
FROM php:7.4-apache

# Copy the application files to the container
COPY . /var/www/html

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change document root to /var/www/html
RUN sed -i 's/\/var\/www\/html/\/var\/www\/html/g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/\/var\/www\/html/\/var\/www\/html/g' /etc/apache2/sites-enabled/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
