<?php

namespace LaravelFrontendUi\Vuetify;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

/**
 * Class VuetifyPresetServiceProvider.
 *
 * @package LaravelFrontendUi\VuetifyUiServiceProvieder
 */
class VuetifyUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        UiCommand::macro('vuetify', function ($command) {
            VuetifyUi::install(false);
            $command->info('Vuetify scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        UiCommand::macro('vuetify-auth', function ($command) { //optional
            VuetifyUi::install(true);
            $command->info('Vuetify scaffolding with Auth views installed successfully.');
            $command->comment('Please run "npm install && npm run dev && php artisan passport:install" to compile your fresh scaffolding.');
        });
    }
}
