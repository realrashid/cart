<?php

namespace RealRashid\Cart\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:install {--force : Republish the scaffolding even if they were already published}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate the installation process of Cart scaffolding.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get the --force option value.
        $force = $this->option('force');

        // Define the path to CartServiceProvider and config file.
        $providerPath = app_path('Providers/CartServiceProvider.php');
        $configPath = config_path('cart.php');

        // Check if Cart scaffolding is already installed.
        $providerInstalled = file_exists($providerPath);
        $configInstalled = file_exists($configPath);

        // If --force is used, and both config and provider are installed, ask for confirmation.
        if ($force && ($providerInstalled || $configInstalled)) {
            if (!$this->confirm('Cart scaffolding is already installed. Do you want to republish the scaffolding?')) {
                $this->info('Installation process aborted.');

                return;
            }
        }

        // If scaffolding is already installed without --force, exit with a message.
        if (!$force && ($providerInstalled || $configInstalled)) {
            $this->info('Cart scaffolding already installed. Use --force to republish.');
            return;
        }

        // Publish Cart scaffolding.
        $this->comment('Initiating the publication of Cart scaffolding...');
        $this->callSilent('vendor:publish', ['--tag' => 'cart-provider', '--force' => $force]);
        $this->callSilent('vendor:publish', ['--tag' => 'cart-config', '--force' => $force]);

        // Output success message.
        $this->info('Cart scaffolding installed successfully.');
    }
}
