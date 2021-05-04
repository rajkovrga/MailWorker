FROM brossquad/php-dev:8.0-1.1.0 as buider

WORKDIR /var/www/html/MailWorkerApi

COPY . .

RUN composer install


FROM brossquad/php-dev:8.0-1.1.0

WORKDIR /var/www/html/MailWorkerApi

COPY . .
COPY --from=builder /var/www/html/MailWorkerApi/vendor ./vendor

RUN  chmod -R 777 storage \
    && chmod -R 777 bootstrap


EXPOSE 9000
EXPOSE 9003

CMD [ "php-fpm" ]
