FROM centos:7

RUN yum install -y epel-release yum-utils
RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm

RUN yum-config-manager --enable remi-php73

RUN yum install -y php \
                php-pdo \
                php-common \
                php-opcache \
                php-mcrypt \
                php-cli \
                zip \
                unzip \
                git \
                php-gd \
                php-curl \
                php-mysql \
                php-odbc \
                php-xml \
                php-fpm \
                pdo-mysql \
                php-mbstring \
                openssl \
                httpd \
                php-zip \
                httpd-tools

RUN localedef -c -f UTF-8 -i es_ES es_ES
RUN localedef -c -f UTF-8 -i es_ES es_ES.UTF-8
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN sed -E -i -e '/<Directory "\/var\/www\/html">/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf
RUN sed -E -i -e 's/DirectoryIndex (.*)$/DirectoryIndex index.php \1/g' /etc/httpd/conf/httpd.conf

RUN yum clean all \
        && rm -rf /var/lib/rpm/__db* \
        && rpm --rebuilddb

ENV APACHE_DOCUMENT_ROOT=/var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/httpd/conf/httpd.conf

COPY . /var/www/
COPY .env.example /var/www/.env

RUN chmod -R 777 /var/www/storage/
RUN chmod -R 777 /var/www/public/
RUN chmod -R 777 /var/www/bootstrap/cache


#php artisan key:generate -y && \

RUN cd /var/www && \
    \
      composer install && \
      php artisan view:clear && \
      php artisan config:cache

EXPOSE 80

CMD ["/usr/sbin/httpd","-D","FOREGROUND"]
