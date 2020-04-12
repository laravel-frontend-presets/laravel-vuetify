Let me know if you have any issues, I'll try to update.
I contacted the original author, but no reply.

# Laravel 7.0+ Frontend Ui for Vuetify with Vuex

A Laravel front-end scaffolding preset for [Vuetify](https://vuetifyjs.com/en/) - a Material Design Component Framework with Vue and Vuex.

## Usage

1. Fresh install Laravel 7.0+ and cd to your app: `laravel new app && cd app` 
2. Install this preset via `composer require laravel-frontend-presets/vuetify`. Laravel 5.0+ will automatically discover this package. No need to register the service provider. For the moment laravel-frontend-presets/vuetify est juste available with laravel 5.0+
4. If your need it for you laravel 7, you can add this on your composer.json 
    ```"repositories": [{ "type": "vcs", "url": "https://github.com/yagami271/laravel-vuetify" }], 
    "require": { "laravel-frontend-presets/vuetify": "dev-master", } 
    
    and lunch composer update
    ```
    
5. composer require laravel/ui 
6. Use `php ui preset vuetify`
7. `composer require laravel/passport`
8. `php artisan migrate`
9. `php ui preset vuetify vuetify-auth` 
10. `npm install`
11. `npm run dev`
6. Configure your favorite database (mysql, sqlite etc.)
9. This packages requires [Laravel Passport](https://laravel.com/docs/passport). Run `php artisan passport:install`
8. `php artisan serve` (or equivalent) to run server and test preset.

### Demo site:

- https://laravel-vuetify.acacha.org
