
# Use the official PHP image
FROM php:7.4-apache

# Copy the current directory contents into the container
COPY . /var/www/html/

# Set permissions (optional, but may be needed)
RUN chown -R www-data:www-data /var/www/html

# Expose the port on which the app will run
EXPOSE 80
