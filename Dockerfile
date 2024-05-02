FROM ubuntu:latest
RUN apt update
RUN apt install php -y 
RUN apt install libapache2-mod-php -y
RUN apt install php-cli -y
RUN  apt install php-cgi -y
RUN apt install php-mysql -y
RUN apt install php-pgsql -y
RUN apt install curl -y
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt install zip unzip php-zip -y
RUN apt-get install php-xml -y
RUN apt-get install php-curl -y