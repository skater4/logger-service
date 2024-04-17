FROM node:21.7.3

RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
        libnotify-bin \
    && rm -r /var/lib/apt/lists/*

RUN mkdir -p /var/www/
WORKDIR /var/www/

CMD ["/bin/true"]
