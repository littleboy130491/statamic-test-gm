<?php

namespace App\Providers;

use App\Bard\CaptionedImageNode;
use Illuminate\Support\ServiceProvider;
use Statamic\Fieldtypes\Bard\Augmentor;

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
        // Gambar di dalam Bard dirender jadi <figure>+<figcaption> kalau
        // asset-nya punya caption di .meta.
        Augmentor::replaceExtension('image', new CaptionedImageNode);
    }
}
