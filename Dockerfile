FROM php:8.1-cli

# unzip and git are needed for composer to run
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first for better cache usage
COPY composer.* .

# Install all the dependencies and clear cache
RUN composer install --no-interaction --prefer-dist --no-progress && \
    composer clear-cache

COPY . .

ENTRYPOINT ["bash"]
