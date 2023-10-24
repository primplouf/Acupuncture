FROM php:apache

RUN DEBIAN_FRONTEND=noninteractive
RUN apt update
RUN apt -yq install zip

#Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

#Move composer.phar to current $PATH to use composer command
RUN mv composer.phar /usr/local/bin/composer

#Add pgsql driver for PDO
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql && echo "extension=pdo_pgsql" >> /usr/local/etc/php/php.ini-development

VOLUME /var/www/html