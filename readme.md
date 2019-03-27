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
We need to download an Alpine Node LTS image, then we run every node command into the mounted folder
#### Unix shell
`docker run --rm -it -v $(pwd):/bipolar_inside_node -w /bipolar_inside_noe -p 3000:3000 -p 3001:3001 node:lts-apine yarn <your-command>`
#### Windows
`MSYS_NO_PATHCONV=1 docker run --rm -it -v /c/Users/USER/ProjectsPHP/bipolar:/bipolar_inside_node -w /bipolar_inside_node -p 3000:3000 -p 3001:3001 node:lts-alpine yarn <your-command>`

If you want to connect project to Mysql use the following host
```ini
DB_HOST=mysql
```