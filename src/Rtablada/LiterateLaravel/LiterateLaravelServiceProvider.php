<?php namespace Rtablada\LiterateLaravel;

use Illuminate\Support\ServiceProvider;

class LiterateLaravelServiceProvider extends ServiceProvider {

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
		$this->app->bind('literate.compiler', function($app) {
			$parser = new \Rtablada\LiteratePhp\Parser;

			return new DirectoryCompiler($app['files'], $parser);
		});

		$this->app->bind('literate.console.compiler-command', function($app) {
			return new Console\LiterateCompilerCommand($app['literate.compiler']);
		});

		$this->commands('literate.console.compiler-command');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
