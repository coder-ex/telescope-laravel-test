<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class EloquentMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Builder::macro('clone', function() {
            return clone $this;
        });
    }

    public function register()
    {
        //
    }
}