<?php

namespace LaravelFrontendPresets\SkeletonPreset;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

/**
 * Class VuetifyPreset.
 *
 * @package LaravelFrontendPresets\SkeletonPreset
 */
class VuetifyPreset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install($withAuth = false)
    {
        static::updatePackages();
        static::updateSass();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::extraFiles();

        if($withAuth)
        {
            static::addAuthTemplates(); // optional
        }

        static::removeNodeModules();
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            'vuetify' => '^1.0',
            'gravatar' => '^1.0',
            'vuex' => '^3.0',
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'jquery',
            'lodash',
            'popper.js',
        ]));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        copy(__DIR__.'/vuetify-stubs/resources/assets/sass/app.scss', resource_path('assets/sass/app.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        (new Filesystem)->delete(
            resource_path('assets/js')
        );
        (new Filesystem)->copyDirectory(__DIR__.'/vuetify-stubs/resources/assets/js', resource_path('assets/js'));

    }

    protected static function updateWelcomePage()
    {
        mkdir(public_path('img'));
        copy(__DIR__.'/vuetify-tasks/public/img/hero.jpeg', public_path('img/hero.jpeg'));
        copy(__DIR__.'/vuetify-tasks/public/img/hero.jpeg', public_path('img/logo.png'));
        copy(__DIR__.'/vuetify-tasks/public/img/hero.jpeg', public_path('img/plane.jpg'));
        copy(__DIR__.'/vuetify-tasks/public/img/hero.jpeg', public_path('img/section.jpg'));
        copy(__DIR__.'/vuetify-tasks/public/img/hero.jpeg', public_path('img/vuetify.ǹg'));
        copy(__DIR__.'/vuetify-stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    protected function extraFiles()
    {
        copy(__DIR__.'/vuetify-tasks/.editorconfig', base_path(''));
        copy(__DIR__.'/vuetify-tasks/.eslintignore', base_path(''));
        copy(__DIR__.'/vuetify-tasks/.eslinrc.js', base_path(''));
    }

    /**
     * Copy Auth view templates.
     *
     * @return void
     */
    protected static function addAuthTemplates()
    {
        // Add Home controller
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/HomeController.php', app_path('Http/Controllers/HomeController.php'));

        // Add Auth routes in 'routes/web.php'
        $auth_route_entry = "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n";
        file_put_contents('./routes/web.php', $auth_route_entry, FILE_APPEND);

        // Copy Skeleton auth views from the stubs folder
        (new Filesystem)->copyDirectory(__DIR__.'/vuetify-stubs/resources/views', resource_path('views'));

        //Overwrite default Auth controllers:
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/ForgotPasswordController.php', app_path('Http/Controllers/Auth'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/LoginController.php', app_path('Http/Controllers/Auth'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/RegisterController.php', app_path('Http/Controllers/Auth'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/ResetPasswordController.php', app_path('Http/Controllers/Auth'));

        // Add LoggedUserController and test
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/LoggedUserController.php', app_path('Http/Controllers'));
        copy(__DIR__.'/vuetify-stubs/tests/Feature/LoggedUserControllerTest.php', base_path('tests/Feature'));

        // Add Logged user route in 'routes/api.php'
        $logged_user_route_entry = "Route::group('['prefix'=>'v1','middleware' => 'auth:api'], function() {\nRoute::put('/user', 'LoggedUserController@update');\n});\n";
        file_put_contents('./routes/api.php', $logged_user_route_entry, FILE_APPEND);

        // Laravel Passport
        copy(__DIR__.'/vuetify-stubs/app/User.php', app_path(''));
        copy(__DIR__.'/vuetify-stubs/app/Providers/AuthServiceProvider.php', app_path('Providers'));
        copy(__DIR__.'/vuetify-stubs/config/auth.php', base_path('config'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Kernel.php', app_path('Http'));
    }
}
