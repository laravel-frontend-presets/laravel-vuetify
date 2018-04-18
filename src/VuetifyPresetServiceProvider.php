<?php

namespace LaravelFrontendPresets\Vuetify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

/**
 * Class VuetifyPresetServiceProvider.
 *
 * @package LaravelFrontendPresets\VuetifyPreset
 */
class VuetifyPresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('vuetify', function ($command) {
            VuetifyPreset::install(false);
            $command->info('Vuetify scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        PresetCommand::macro('vuetify-auth', function ($command) { //optional
            VuetifyPreset::install(true);
            $command->info('Vuetify scaffolding with Auth views installed successfully.');
            $command->comment('Please run "npm install && npm run dev && php artisan passport:install" to compile your fresh scaffolding.');
        });
    }
}
