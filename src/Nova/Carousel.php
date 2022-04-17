<?php

namespace Armincms\Widgets\Slider\Nova;
   
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\HasMany; 
use Laravel\Nova\Fields\ID; 
use Laravel\Nova\Fields\Text;  

class Carousel extends Resource
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Widgets\Slider\Models\Carousel::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(), 

            Text::make(__('Carousel Name'), 'name')->sortable()->required(),

            HasMany::make(__('Carousel Items'), 'items', CarouselItem::class),
        ];
    }  
}
