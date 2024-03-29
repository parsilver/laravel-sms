<?php namespace Parsilver\SMS;

use Illuminate\Support\ServiceProvider;
use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Contract\SMSProviderFactory;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__."/../config.php", "sms");

        $this->app->singleton(SMSProviderFactory::class, function($app) {
            return new Manager($app);
        });

        $this->app->bind(SMSProvider::class, function() {
            return $this->app->make(SMSProviderFactory::class)->driver();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config.php' => $this->app->configPath('sms.php'),
            ], 'config');
        }
    }
}