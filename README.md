<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

A project in which we obtain information about planets and its residents from the
url https://swapi.py4e.com/api/planets/ by executing sync:planets command. Queued planets synchronization is possible
with ```-Q``` or ```--queued``` option. We used redis queue workers during development. Using blade components,
livewire, alpinejs, tailwind and the vite build tool, we also display list of planets in simple table with pagination,
filtering and searching. We use own bindings in to the service container to perform dependency injection in the whole
project for better testability. Our BladeServiceProvider register new directory path for layout anonymous components for
better blade files organization. Application also provide GraphQL endpoints for the aggregated data about the planets
and for creating a new record in the logbook. Try endpoints in ```'application_url'/graphiql```. With PHPUnit tests we
covered all GraphQL endpoints. In GraphQLServiceProvider we register new enum types. As PHP code style fixer we use Laravel Pint.

## Installation on the dev enviroment

1. installed docker is required
2. create ```.env``` file from ```.env.example``` file
3. no changes are required when you want to run this project on its docker containers
4. ```QUEUE_CONNECTION``` variable in ```.env.example``` file is set to ```redis``` because redis server will be running
   in docker
5. run ```docker run --rm \ ```<br>
   ```-u "$(id -u):$(id -g)" \ ```<br>
   ```-v "$(pwd):/var/www/html" \ ```<br>
   ```-w /var/www/html \ ```<br>
   ```laravelsail/php82-composer:latest \ ```<br>
   ```composer install --ignore-platform-reqs``` to install application dependencies and also Laravel Sail
6. run ```./vendor/bin/sail up``` to run all containers in ```docker-compose.yml``` (php server, mysql server, redis
   server etc.)
7. if you want, create sail shell alias with ```alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'```
8. run ```sail artisan key:generate``` to generate applications key
9. run ```sail artisan migrate``` to run database migrations
10. run ```sail artisan queue:work``` to run queue worker (run more workers in more terminals for distributing jobs and
    parallel running)
11. run ```sail artisan sync:planets``` to sync planets from default url ```https://swapi.py4e.com/api/planets``` or
    specify url as command argument. For queued planet synchronization use ```-Q``` or ```--queue``` option with running
    queue workers
12. run ```sail npm run dev``` for vite dev server for realtime building frontend files or build them by
    running ```sail npm run build```
13. run ```sail test``` to run PHPUnit tests

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
