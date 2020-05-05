<?php

namespace LaravelFrontendUi\Vuetify;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
/**
 * Class VuetifyUi.
 *
 * @package LaravelFrontendUi\VuetifyUi
 */
class VuetifyUi
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

    

    /**
     * Update the "package.json" file.
     *
     * @return void
     */
    protected static function updatePackages()
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['devDependencies'] = static::updatePackageArray(
            $packages['devDependencies']
        );

        ksort($packages['devDependencies']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Remove the installed Node modules.
     *
     * @return void
     */
    protected static function removeNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
        });
    }



    /**
     * Update package array.
     *
     * @param array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            'vuetify' => '^2.1.13',
            'gravatar' => '^1.0',
            'vue' => '^2.6.10',
            'vue-template-compiler' => '^2.6.10',
            'vuex' => "^3.1.2",
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
        copy(__DIR__.'/vuetify-stubs/resources/sass/app.scss', resource_path('sass/app.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        (new Filesystem)->delete(
            resource_path('js')
        );
        (new Filesystem)->copyDirectory(__DIR__.'/vuetify-stubs/resources/js', resource_path('js'));

    }

    /**
     * Update welcome page.
     */
    protected static function updateWelcomePage()
    {
        if ( ! file_exists(public_path('img'))) mkdir(public_path('img'));
        copy(__DIR__.'/vuetify-stubs/public/img/hero.jpeg', public_path('img/hero.jpeg'));
        copy(__DIR__.'/vuetify-stubs/public/img/logo.png', public_path('img/logo.png'));
        copy(__DIR__.'/vuetify-stubs/public/img/plane.jpg', public_path('img/plane.jpg'));
        copy(__DIR__.'/vuetify-stubs/public/img/section.jpg', public_path('img/section.jpg'));
        copy(__DIR__.'/vuetify-stubs/public/img/vuetify.png', public_path('img/vuetify.png'));
        copy(__DIR__.'/vuetify-stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /*
     * Extra files.
     */
    protected static function extraFiles()
    {
        copy(__DIR__.'/vuetify-stubs/.editorconfig', base_path('.editorconfig'));
        copy(__DIR__.'/vuetify-stubs/.eslintignore', base_path('.eslintignore'));
        copy(__DIR__.'/vuetify-stubs/.eslintrc.js', base_path('.eslintrc.js'));
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

        // Copy Vuetify auth views from the stubs folder
        (new Filesystem)->copyDirectory(__DIR__.'/vuetify-stubs/resources/views', resource_path('views'));

        //Overwrite default Auth controllers:
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/ForgotPasswordController.php',
            app_path('Http/Controllers/Auth/ForgotPasswordController.php'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/LoginController.php',
            app_path('Http/Controllers/Auth/LoginController.php'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/RegisterController.php',
            app_path('Http/Controllers/Auth/RegisterController.php'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/Auth/ResetPasswordController.php',
            app_path('Http/Controllers/Auth/ResetPasswordController.php'));

        // Add LoggedUserController and test
        copy(__DIR__.'/vuetify-stubs/app/Http/Controllers/LoggedUserController.php',
            app_path('Http/Controllers/LoggedUserController.php'));
        copy(__DIR__.'/vuetify-stubs/tests/Feature/LoggedUserControllerTest.php',
            base_path('tests/Feature/LoggedUserControllerTest.php'));

        // Add Logged user route in 'routes/api.php'
        $logged_user_route_entry = "\nRoute::group(['prefix'=>'v1','middleware' => 'auth:api'], function() {\n\tRoute::put('/user', 'LoggedUserController@update');\n});\n";
        file_put_contents('./routes/api.php', $logged_user_route_entry, FILE_APPEND);

        // Laravel Passport
        copy(__DIR__.'/vuetify-stubs/app/User.php', app_path('User.php'));
        copy(__DIR__.'/vuetify-stubs/app/Providers/AuthServiceProvider.php', app_path('Providers/AuthServiceProvider.php'));
        copy(__DIR__.'/vuetify-stubs/config/auth.php', config_path('auth.php'));
        copy(__DIR__.'/vuetify-stubs/app/Http/Kernel.php', app_path('Http/Kernel.php'));
    }
}
