FROM ubuntu:16.04

RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv EA312927
#RUN echo "deb http://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.2 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-3.2.list
RUN apt-get update && apt-get install -y \
    apache2 \
    php7.0 \
    php7.0-cli \
    libapache2-mod-php7.0 \
    php7.0-json \
    php7.0-curl \
    php7.0-dev \
    php-pear \
#    mongodb-org \
    libsasl2-dev \
    pkg-config \
    git \
#    phantomjs \
    fontconfig \
    unzip

RUN pecl install mongodb
RUN a2dismod status
RUN a2enmod rewrite

#COPY mongod.service /lib/systemd/system/
#RUN mkdir -p /data/mu
#RUN mkdir -p /data/db

#RUN systemctl unmask mongod
#RUN systemctl start mongod
#RUN service mongod start
#RUN /usr/bin/mongod &
#RUN /usr/bin/mongod --config /etc/mongod.conf &

COPY bot.js /root
COPY phantomjs /root

WORKDIR /var/www/html

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR
RUN rm -rf /var/www/html/index.html

COPY composer.json /var/www/
COPY composer.lock /var/www/
COPY initdb.js /tmp/
COPY ./web/ /var/www/html

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer

RUN touch /etc/php/7.0/mods-available/mongodb.ini
RUN echo "; priority=99" >> /etc/php/7.0/mods-available/mongodb.ini
RUN echo "extension=mongodb.so" >> /etc/php/7.0/mods-available/mongodb.ini
RUN ln -s /etc/php/7.0/mods-available/mongodb.ini /etc/php/7.0/cli/conf.d/99-mongodb.ini
RUN ln -s /etc/php/7.0/mods-available/mongodb.ini /etc/php/7.0/apache2/conf.d/99-mongodb.ini
 
#RUN php -m
RUN chmod 777 uploads
RUN chown -R www-data uploads

RUN cd /var/www && composer install --no-progress

#RUN mongo hackaflag /tmp/initdb.js
RUN echo "CTF-BR{mimimi_my_F1rst_CSRF}" > /flag

#RUN service apache2 start
RUN nohup /root/phantomjs /root/bot.js &

EXPOSE 80

CMD ["/usr/sbin/apache2","-DFOREGROUND"]
