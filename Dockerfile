# Use the official PHP image with CLI
FROM php:7.4-cli

# Install Composer
RUN apt-get update && \
    apt-get install -y unzip && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo_mysql

# Set the working directory
WORKDIR /var/www/html

# Copy the application code into the container
COPY . /var/www/html

# Expose any ports the app is expecting in the environment
# For example, if your app is on port 8080, use: EXPOSE 8080
EXPOSE 8080

