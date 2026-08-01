FROM node:8.17.0 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install --unsafe-perm=true \
    && npm install --no-save --unsafe-perm=true is-utf8@0.2.1

COPY . .

RUN npm run build


FROM php:7.4-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite \
    && printf '%s\n' \
        '<Directory /var/www/html>' \
        '    Options FollowSymLinks' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/petrescue.conf \
    && a2enconf petrescue

COPY --from=frontend /app/public_html/ /var/www/html/
COPY --from=frontend /app/php/ /var/www/php/

WORKDIR /var/www/html

EXPOSE 80
