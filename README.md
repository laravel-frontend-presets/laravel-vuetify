Sorry no time to mantain this package: if anyone is interested to mantain it please email me at sergiturbadenas at gmail.com

# Laravel 6.0+ Frontend preset for Vuetify with Vuex

A Laravel front-end scaffolding preset for [Vuetify](https://vuetifyjs.com/en/) - a Material Design Component Framework with Vue and Vuex.

## Usage

1. Fresh install Laravel 5.5+ and cd to your app: `laravel new app && cd app` 
2. Install this preset via `composer require laravel-frontend-presets/vuetify`. Laravel 5.5+ will automatically discover this package. No need to register the service provider.
3. Use `php artisan preset vuetify` for the basic Vuetify frontend preset OR use `php artisan preset vuetify-auth` for the basic preset auth scaffolding in one go. (NOTE: If you run this command several times, be sure to clean up the duplicate Auth entries in `routes/web.php`)
4. `npm install`
5. `npm run dev`
6. Configure your favorite database (mysql, sqlite etc.)
7. `php artisan migrate` to create basic user tables.
9. This packages requires [Laravel Passport](https://laravel.com/docs/passport). Run `php artisan passport:install`
8. `php artisan serve` (or equivalent) to run server and test preset.

### Demo site:

- https://laravel-vuetify.acacha.org
