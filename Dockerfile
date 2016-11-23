FROM php:7.0-apache

RUN echo "deb http://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.2 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.2.list
RUN apt-get update && apt-get install -y \
    php-curl \
    php-pear \
    php-dev \
    mongodb-org \
    phantomjs

RUN pecl install mongodb
RUN a2dismod status
RUN a2enmod rewrite
RUN service mongod start

COPY bot.js /root

WORKDIR /var/www/html

COPY composer.json /var/www/html
COPY composer.lock /var/www/html
COPY ./web/ /var/www/html

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php')"
RUN mv composer.phar /bin/composer

RUN echo "extension=mongodb.so" >> /etc/php/7.0/cli/php.ini
RUN echo "extension=mongodb.so" >> /etc/php/7.0/apache2/php.ini

RUN chmod 777 uploads
RUN chown -R www-data uploads

RUN composer install --no-progress

RUN echo "CTF-BR{mimimi_my_F1rst_CSRF}" > /flag

RUN phantomjs /root/bot.js &&

EXPOSE 80
