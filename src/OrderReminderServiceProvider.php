<?php

namespace Rapidez\OrderReminder;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Rapidez\OrderReminder\Http\ViewComposers\ConfigComposer;
use Rapidez\OrderReminder\Console\Commands\SendOrderRemindersCommand;

class OrderReminderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rapidez-order-reminder.php', 'rapidez-order-reminder');
    }

    public function boot()
    {
        $this
            ->bootRoutes()
            ->bootTranslations()
            ->bootViews()
            ->bootMigrations()
            ->bootComposers()
            ->bootCommands()
            ->bootPublishables();
    }

    public function bootRoutes() : self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        return $this;
    }

    protected function bootTranslations(): static
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'rapidez-order-reminder');

        return $this;
    }

    public function bootViews() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-order-reminder');

        return $this;
    }

    public function bootMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    protected function bootComposers(): static
    {
        View::composer('rapidez::layouts.app', ConfigComposer::class);

        return $this;
    }

    protected function bootCommands(): static
    {
        $this->commands([SendOrderRemindersCommand::class]);

        return $this;
    }

    public function bootPublishables() : self
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/rapidez-order-reminder'),
        ],'views');

        $this->publishes([
            __DIR__ . '/../config/rapidez-order-reminder.php' => config_path('rapidez-order-reminder.php'),
        ], 'config');

        return $this;
    }
}
