FROM php:7.4.33-zts-alpine3.16

WORKDIR /src

EXPOSE 80

RUN docker-php-ext-install mysqli

CMD [ "php", "-S", "0.0.0.0:80" ]
