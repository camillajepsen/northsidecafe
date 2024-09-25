# Use the official PHP image
FROM php:7.4-apache

# Install the mysqli extension
RUN docker-php-ext-install mysqli

# Copy the current directory contents into the container
COPY . /var/www/html/

# Set permissions (optional, but may be needed)
RUN chown -R www-data:www-data /var/www/html

# Change the Apache configuration to use the PORT environment variable
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf

# Expose the dynamic port
EXPOSE ${PORT}

# Start Apache in the foreground
CMD ["apache2-foreground"]
