<?php

namespace Armincms\Widgets\Slider; 
 
use Armincms\Koomeh\Models\KoomehProperty;
use Zareismail\Gutenberg\Template; 
use Zareismail\Gutenberg\Variable;

class SliderWidget extends Template 
{    
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    { 
        $conversions = Nova\CarouselItem::newModel()->conversions()->implode(',');

        return [  
            Variable::make('options.controls', __('Display carousel controls')),
            Variable::make('options.indicator', __('Display carousel indicator')),
            Variable::make('options.autoplay', __('Auto play carousel')),
            Variable::make('options.rtl', __('Display right to left carousel')),
            Variable::make('options.touch', __('Touch Swiping carousel item')),
            Variable::make('options.pause', __('Pause on hover carousel item')),
            Variable::make('options.infinite', __('Infinite carousel')),
            Variable::make('options.speed', __('Speed of carousel')),

            Variable::make('title', __('Title of carousel item')),
            Variable::make('caption', __('Caption of carousel item')),
            Variable::make('link', __('Link of carousel item')),
            Variable::make('target', __('Link target of carousel item')),
            Variable::make('order', __('Order of carousel item')),

            Variable::make('items.x.image', __(
                "The carousel item image. available conversions is:[{$conversions}]"
            )),
        ];
    } 
}
