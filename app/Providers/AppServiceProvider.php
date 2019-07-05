<?php

namespace App\Providers;

use Bootstrapper\Form;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(
            'bootstrapper::form',
            function ($app) {
                $form = new Form(
                    $app->make('collective::html'),
                    $app->make('url'),
                    $app->make('view'),
                    $app['session.store']->token()
                );

                return $form->setSessionStore($app['session.store']);
            },
            true
        );
    }


}
