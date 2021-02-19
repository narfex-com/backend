FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.4-mysql php7.4-redis php7.4-bcmath php7.4-gd php7.4-gmp php7.4-imagick php7.4-soap php7.4-yaml php7.4-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && echo "zend_extension=/usr/lib/php/20190902/xdebug.so" > /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /etc/php/7.4/mods-available/xdebug.ini

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update -y
RUN apt-get install

COPY start.sh /usr/local/bin/start
RUN chmod 755 /usr/local/bin/start

RUN apt-get -y install cron
RUN apt-get update -y

COPY cron/crontab /etc/cron.d/crontab
RUN crontab -u root /etc/cron.d/crontab
RUN chmod +x /etc/cron.d/crontab
RUN touch /var/log/cron.log
CMD ["/usr/local/bin/start"]
