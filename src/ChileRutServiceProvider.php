<?php namespace Malahierba\ChileRut;

use Illuminate\Support\ServiceProvider;

class ChileRutServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('chilerut', function(){
            return new ChileRut;
        });
    }
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }
}
