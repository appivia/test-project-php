FROM php:7.4.33-zts-alpine3.16

WORKDIR /src

EXPOSE 3000

RUN docker-php-ext-install mysqli

CMD [ "php", "-S", "0.0.0.0:3000" ]
