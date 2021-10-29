<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data) use ($factory) {
            $customFormat = [
                'code' => 200,
                'data' => $data,
            ];
            return $factory->make($customFormat);
        });

        $factory->macro('err', function ($msg) use ($factory) {
            $customFormat = [
                'code' => 500,
                'msg' => $msg,
            ];
            return $factory->make($customFormat);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
