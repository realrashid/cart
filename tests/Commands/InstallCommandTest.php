<?php

$provider = realpath(dirname(__DIR__) . '/../config/cart.php');
$config = realpath(dirname(__DIR__) . '/../config/cart.php');

it('installs the scaffolding', function () use ($provider, $config) {
    // Create dummy CartServiceProvider.php and config file
    file_put_contents(app_path('Providers/CartServiceProvider.php'), file_get_contents($provider));
    file_put_contents(config_path('cart.php'), file_get_contents($config));

    // Remove CartServiceProvider.php and config file to simulate it doesn't exist
    unlink(app_path('Providers/CartServiceProvider.php'));
    unlink(config_path('cart.php'));

    // Run the cart:install command
    $this->artisan('cart:install')->expectsOutput('Cart scaffolding installed successfully.');

    // Check that the CartServiceProvider.php and config file have been created
    $this->assertTrue(file_exists(app_path('Providers/CartServiceProvider.php')));
    $this->assertTrue(file_exists(config_path('cart.php')));
});

it('aborts installation if user chooses not to republish', function () use ($provider, $config) {
    // Create dummy CartServiceProvider.php and config file
    file_put_contents(app_path('Providers/CartServiceProvider.php'), file_get_contents($provider));
    file_put_contents(config_path('cart.php'), file_get_contents($config));

    // Run the cart:install command
    $this->artisan('cart:install --force')
        ->expectsConfirmation('Cart scaffolding is already installed. Do you want to republish the scaffolding?', 'no')
        ->expectsOutput('Installation process aborted.')
        ->assertExitCode(0);

    // Check that the CartServiceProvider.php and config file exist
    $this->assertTrue(file_exists(app_path('Providers/CartServiceProvider.php')));
    $this->assertTrue(file_exists(config_path('cart.php')));
});

it('does not install the scaffolding if already installed without --force', function () use ($provider, $config) {
    // Create dummy CartServiceProvider.php and config file
    file_put_contents(app_path('Providers/CartServiceProvider.php'), file_get_contents($provider));
    file_put_contents(config_path('cart.php'), file_get_contents($config));

    // Run the cart:install command
    $this->artisan('cart:install')->expectsOutput('Cart scaffolding already installed. Use --force to republish.');

    // Check that the CartServiceProvider.php and config file still exist
    $this->assertTrue(file_exists(app_path('Providers/CartServiceProvider.php')));
    $this->assertTrue(file_exists(config_path('cart.php')));
});

it('republishes the scaffolding even if already installed with --force', function () use ($provider, $config) {
    // Create dummy CartServiceProvider.php and config file
    file_put_contents(app_path('Providers/CartServiceProvider.php'), file_get_contents($provider));
    file_put_contents(config_path('cart.php'), file_get_contents($config));

    // Run the cart:install command with the --force option
    $this->artisan('cart:install --force')
        ->expectsConfirmation('Cart scaffolding is already installed. Do you want to republish the scaffolding?', 'yes')
        ->expectsOutput('Cart scaffolding installed successfully.');
});
