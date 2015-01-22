<?php namespace MalahierbaLab\ChileRut;

use Illuminate\Support\ServiceProvider;

class ChileRutServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['chilerut'] = $this->app->share(function($app)
		{
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
		$this->package('malahierba-lab/chile-rut');
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('chilerut');
	}

}
