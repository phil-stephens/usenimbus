<?php namespace Nimbus\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Nimbus\Services\Registrar'
		);

        $this->app->singleton('Nimbus\Glide\Server', function ($app)
        {

            // Set image source
            $source = filesystem()->init(env('DEFAULT_FILESYSTEM'));

            // Set image cache
            $cache = filesystem()->init(env('GLIDE_CACHE'));

            // Set image manager
            $imageManager = new \Intervention\Image\ImageManager([
                'driver' => env('INTERVENTION_DRIVER', 'gd'),
            ]);

            // Set manipulators
            $manipulators = [
                new \League\Glide\Api\Manipulator\Orientation(),
                new \League\Glide\Api\Manipulator\Rectangle(),
                new \League\Glide\Api\Manipulator\Size(2000 * 2000),
                new \League\Glide\Api\Manipulator\Brightness(),
                new \League\Glide\Api\Manipulator\Contrast(),
                new \League\Glide\Api\Manipulator\Gamma(),
                new \League\Glide\Api\Manipulator\Sharpen(),
                new \League\Glide\Api\Manipulator\Filter(),
                new \League\Glide\Api\Manipulator\Blur(),
                new \League\Glide\Api\Manipulator\Pixelate(),
                new \Nimbus\Glide\Manipulator\Watermark($source),
                new \League\Glide\Api\Manipulator\Output(),
            ];

            // Set API
            $api = new \League\Glide\Api\Api($imageManager, $manipulators);

            // Setup Glide server
            $server = new \Nimbus\Glide\Server($source, $cache, $api);

            $server->setBaseUrl('/img/');

            $server->setCachePathPrefix('.cache');

            return $server;
        });
	}

}
