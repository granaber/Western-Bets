FROM phpdockerio/php:8.2-fpm
WORKDIR  "/code-westernbets"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
    php8.2-grpc \ 
    php8.2-mysql \ 
    php8.2-protobuf; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*