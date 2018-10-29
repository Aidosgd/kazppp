<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class ComposerServiceProvider extends ServiceProvider
{


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (!app()->runningInConsole() && $request->segment(1) == 'admin' && $request->segment(2) != 'auth') {
            View::composer('backend*', 'App\Http\ViewComposers\Backend\UserComposer');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}