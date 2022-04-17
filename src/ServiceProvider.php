<?php

namespace Armincms\Widgets\Slider;

use Illuminate\Contracts\Support\DeferrableProvider; 
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;  
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\Gutenberg\Gutenberg; 

class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{   
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        LaravelNova::resources([
            Nova\Carousel::class,
            Nova\CarouselItem::class,
        ]);

        Gutenberg::widgets([
            Slider::class,
        ]);
        Gutenberg::templates([
            SliderWidget::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    } 

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [
            \Illuminate\Console\Events\ArtisanStarting::class,
            \Laravel\Nova\Events\ServingNova::class,
        ];
    }
}
