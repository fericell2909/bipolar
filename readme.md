# Bipolar

## Docker development setup
Run the following commands

```sh
cp .env.example .env
docker-compose run --rm --no-deps bipolar-server composer install
docker-compose run --rm --no-deps bipolar-server php artisan key:generate
docker-compose up -d
```

If you want to connect project to Mysql use the following host
```ini
DB_HOST=mysql
```