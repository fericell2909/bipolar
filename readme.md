# Bipolar

## Docker development setup
Run the following commands

```sh
cp .env.example .env
docker-compose run --rm --no-deps bipolar-server composer install
docker-compose run --rm --no-deps bipolar-server php artisan key:generate
docker-compose up -d
```

### Execute Node/Yarn inside of container
#### Unix shell
`docker run --rm -it -v $(pwd):/app -w /app node yarn`
#### Windows
`MSYS_NO_PATHCONV=1 docker run --rm -it -v /c/Users/USER/ProjectsPHP/bipolar/app:/app -w /app node yarn`


If you want to connect project to Mysql use the following host
```ini
DB_HOST=mysql
```