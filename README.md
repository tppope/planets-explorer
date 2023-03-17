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



## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
