# Make Magic API

Backend API for managing Harry Potter characters.

Built with PHP 7.4 and Lumen 8.x.

## Configuration

You need a PHP development  as described in [Lumen documentation](https://lumen.laravel.com/docs/8.x#installation) with composer installed.

Then run the follow commands in your terminal:
```
composer install
cp env.example .env
php artisan key:generate
```

Edit the .env file with your database configuration (you may use the postgres service from the included [docker-compose](Docker-compose))

With the database configuration done run the migrations with:
```
php artisan migrate
```

For local development there is a ```run.sh``` script with the following command to run the PHP localserver:
```
php -S localhost:80 -t public
```

## Docker

There is a docker image based on the official PHP image and a docker-compose.yml file.

### Docker-compose

The included docker-compose file has a postgres service based on the official image that you can use by defining the variables POSTGRES_DB, POSTGRES_USER and POSTGRES_PASSWORD in the .env file and then running :
```
docker-compose up -d postgres
```

## Testing

There are Unit and Integration testing scripts in the /tests folder using Lumen's PHPUnit native integration. 

You can run them using the a ```phpunit.sh``` shell script that calls the PHPUnit file from the vendor folder.