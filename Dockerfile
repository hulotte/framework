FROM webdevops/php-apache-dev:8.0

# Timezone setup
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime

WORKDIR /app
