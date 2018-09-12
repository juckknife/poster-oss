<?php

namespace Juckknife\PosterOss;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Poster::class, function () {
            return new Poster();
        });

        $this->app->alias(Poster::class, 'poster');
    }

    public function provides()
    {
        return [Poster::class, 'weather'];
    }
}