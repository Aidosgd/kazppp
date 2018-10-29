<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JSONApiResponse\JSONApiResponse;
use App\Services\MediaService\MediaService;
use App\Services\UploaderService\UploaderService;

class AppServiceProvider extends ServiceProvider
{
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
     * @return void
     */
    public function register()
    {
        // Обработчик ответов в формате json
        $this->app->singleton('JSON', function()
        {
            return new JSONApiResponse();
        });

        // Медиа сервис
        $this->app->singleton('MediaService', function()
        {
            return new MediaService();
        });

        // Аплоадер сервис
        $this->app->singleton('UploaderService', function()
        {
            return new UploaderService();
        });
    }
}
