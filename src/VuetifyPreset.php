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
        static::removeSass(); // or static::updateLess()
        static::updateBootstrapping();
        static::updateWelcomePage();

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
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'jquery',
            'popper.js',
        ]));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function removeSass()
    {
        // remove sass assets
        (new Filesystem)->delete(
            resource_path('assets/sass')
        );
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        (new Filesystem)->delete(
            base_path('webpack.min.js')
        );
        copy(__DIR__.'/vuetify-stubs/webpack.min.js', base_path('webpack.min.js'));
        (new Filesystem)->delete(
            resource_path('assets/js/bootstrap.js')
        );
        copy(__DIR__.'/vuetify-stubs/js/bootstrap.js', resource_path('assets/js/bootstrap.js'));
        (new Filesystem)->delete(
            resource_path('assets/js/app.js')
        );
        copy(__DIR__.'/vuetify-stubs/js/app.js', resource_path('assets/js/app.js'));

        (new Filesystem)->delete(
            resource_path('assets/js/components/ExampleComponent.vue')
        );
        copy(__DIR__.'/vuetify-stubs/js/components/LoginButtonComponent.js', resource_path('assets/js/components/LoginButtonComponent.js'));
        copy(__DIR__.'/vuetify-stubs/js/components/RegisterButtonComponent.js', resource_path('assets/js/components/RegisterButtonComponent.js'));
    }

    protected static function updateWelcomePage()
    {
        mkdir(public_path('img'));
        copy(__DIR__.'/vuetify-tasks/img/hero.jpeg', public_path('img/hero.jpeg'));
        copy(__DIR__.'/vuetify-tasks/img/hero.jpeg', public_path('img/logo.png'));
        copy(__DIR__.'/vuetify-tasks/img/hero.jpeg', public_path('img/plane.jpg'));
        copy(__DIR__.'/vuetify-tasks/img/hero.jpeg', public_path('img/section.jpg'));
        copy(__DIR__.'/vuetify-tasks/img/hero.jpeg', public_path('img/vuetify.ǹg'));
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));
        copy(__DIR__.'/vuetify-stubs/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Copy Auth view templates.
     *
     * @return void
     */
    protected static function addAuthTemplates()
    {
        // Add Home controller
        copy(__DIR__.'/vuetify-stubs/Controllers/HomeController.php', app_path('Http/Controllers/HomeController.php'));

        // Add Auth routes in 'routes/web.php'
        $auth_route_entry = "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n";
        file_put_contents('./routes/web.php', $auth_route_entry, FILE_APPEND);

        // Copy Skeleton auth views from the stubs folder
        (new Filesystem)->copyDirectory(__DIR__.'/vuetify-stubs/views', resource_path('views'));
    }
}
