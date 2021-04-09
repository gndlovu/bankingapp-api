<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DingoSerializerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
            $fractal = new \League\Fractal\Manager;
            $fractal->setSerializer(new \App\Api\V1\Serializers\NoDataArraySerializer);
            return new \Dingo\Api\Transformer\Adapter\Fractal($fractal);
        });
    }
}
