<?php namespace Parsilver\SMS;

use Illuminate\Support\ServiceProvider;
use Parsilver\SMS\Contract\SMSProvider;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => $this->app->configPath('sms.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SMSProvider::class, function($app) {
            return (new Manager($app))->driver();
        });
    }
}