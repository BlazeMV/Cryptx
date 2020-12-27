<?php

namespace Blaze\Cryptx;

use Illuminate\Support\ServiceProvider;

class CryptxServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadConfigs();

        $this->registerCommands();
    }

    public function loadConfigs()
    {
        $path = realpath(__DIR__.'/../config/config.php');

        $this->publishes([$path => config_path('cryptx.php')]);

        $this->mergeConfigFrom($path, 'cryptx');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCryptxKeys::class,
            ]);
        }
    }

    public function register()
    {

        $this->app->singleton('cryptx', function () {
            $config = config('cryptx');
            return new Cryptx($config['secret_key_path'], $config['public_key_path'], $config['keypair_options']);
        });
    }

    public function provides()
    {
        return ['cryptx'];
    }
}