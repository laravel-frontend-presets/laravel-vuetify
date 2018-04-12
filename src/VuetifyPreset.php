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

        if($withAuth)
        {
            static::addAuthTemplates(); // optional
        }
        else
        {
            static::updateWelcomePage(); //optional
        }

        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        // packages to add to the package.json
        $packagesToAdd = ['package-name' => '^version'];
        // packages to remove from the package.json
        $packagesToRemove = ['package-name' => '^version'];
        return $packagesToAdd + Arr::except($packages, $packagesToRemove);
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function removeSass()
    {
        // clean up all the files in the sass folder
        $orphan_sass_files = glob(resource_path('/assets/sass/*.*'));

        foreach($orphan_sass_files as $sass_file)
        {
            (new Filesystem)->delete($sass_file);
        }

    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        // remove exisiting bootstrap.js file
        (new Filesystem)->delete(
            resource_path('assets/js/bootstrap.js')
        );

        // copy a new bootstrap.js file from your stubs folder
        copy(__DIR__.'/skeleton-stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    /**
     * Update the default welcome page file.
     *
     * @return void
     */
    protected static function updateWelcomePage()
    {
        // remove default welcome page
        (new Filesystem)->delete(
            resource_path('views/welcome.blade.php')
        );

        // copy new one from your stubs folder
        copy(__DIR__.'/skeleton-stubs/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Copy Auth view templates.
     *
     * @return void
     */
    protected static function addAuthTemplates()
    {
        // Add Home controller
        copy(__DIR__.'/stubs-stubs/Controllers/HomeController.php', app_path('Http/Controllers/HomeController.php'));

        // Add Auth routes in 'routes/web.php'
        $auth_route_entry = "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n";
        file_put_contents('./routes/web.php', $auth_route_entry, FILE_APPEND);

        // Copy Skeleton auth views from the stubs folder
        (new Filesystem)->copyDirectory(__DIR__.'/foundation-stubs/views', resource_path('views'));
    }
}
