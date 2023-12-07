<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //



        Validator::extend('aspect_ratio', function ($attribute, $value, $parameters, $validator) {

            [$width, $height] = getimagesize($value);
    

            $aspectRatio = $width / $height;
    

            return abs($aspectRatio - (16 / 9)) < 0.01;
        }, 'Соотношение сторон превью должно быть 16:9');

    }
}
