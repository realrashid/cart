<?php

namespace RealRashid\Cart;

use Illuminate\Support\ServiceProvider;
use RealRashid\Cart\Commands\InstallCommand;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        /*
         * Registering the helper methods to package
         */
        $this->registerHelpers();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register helpers file
     *
     * @author Rashid Ali <realrashid05@gmail.com>
     */
    public function registerHelpers(): void
    {
        // Load the helpers in src/functions.php
        if (file_exists($file = __DIR__.'/functions.php')) {
            require $file;
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cart.php', 'cart-config');

        // Register the main class to use with the facade
        $this->app->singleton('cart', function ($app) {
            return $this->app->make(Cart::class);
        });
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the Service Provider file.
        $this->publishes([
            __DIR__.'/../stub/CartServiceProvider.php' => app_path('Providers/CartServiceProvider.php'),
        ], 'cart-provider');

        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/cart.php' => config_path('cart.php'),
        ], 'cart-config');

        // Registering package commands.
        $this->commands([
            InstallCommand::class,
        ]);
    }
}
