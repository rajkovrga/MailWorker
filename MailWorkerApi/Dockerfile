FROM brossquad/php-dev:8.0-1.0.5

WORKDIR /var/www/html

COPY . .

RUN  chmod -R 777 storage \
    && chmod -R 777 bootstrap


EXPOSE 9000
EXPOSE 9003

CMD [ "php-fpm" ]