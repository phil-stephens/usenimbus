<?php namespace Nimbus\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('storage', function () {
            return $this->app->make('Nimbus\Storages\Filesystem');
        });
    }
}