<?php

namespace Lanos\SendgridTenancy;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the package.
 *
 * @package Lanos\CashierConnect\Providers
 */
class SendgridTenancyServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initializeMigrations();
        $this->initializePublishing();
        $this->initializeCommands();
        $this->setupConfig();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sgten.php', 'sgten'
        );
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function initializeMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function initializePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'sendgrid-tenancy-migrations');
        }
    }

    /**
     * Register the package's console commands.
     *
     * @return void
     */
    protected function initializeCommands()
    {
        if ($this->app->runningInConsole()) {

        }
    }

    /**
     * Register the package's console commands.
     *
     * @return void
     */
    protected function setupRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/senders.php');
    }

    /**
     * Register the package's config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/sgten.php' => config_path('sgten.php'),
        ]);
    }


}