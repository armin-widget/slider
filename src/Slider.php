<?php

namespace Armincms\Widgets\Slider;
 
use Armincms\Widgets\Slider\Nova\Carousel;   
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;   
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Gutenberg\GutenbergWidget; 

class Slider extends GutenbergWidget
{        

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {  
        parent::boot($request, $layout); 

        $this->renderable(function() use ($request) {
            return ! is_null($this->carousel());
        }); 
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {   
        return [ 
            Select::make(__('Carousel'), 'config->carousel')
                ->options(Nova\Carousel::newModel()->get()->pluck('name', 'id'))
                ->required()
                ->rules('required'), 

            Number::make(__('Carousel speed [ms]'), 'config->speed')
                ->required()
                ->min(100)
                ->default(2000)
                ->rules('required', 'digits_between:3,4'),

            BooleanGroup::make(__('Carousel options'), 'config->options')
                ->options($optsions = [
                    'controls'  => __('Display carousel controls'),
                    'indicator' => __('Display carousel indicator'),
                    'autoplay'  => __('Auto play carousel'),
                    'rtl'       => __('Display right to left carousel'),
                    'touch'     => __('Touch Swiping carousel item'),
                    'pause'     => __('Pause on hover carousel item'),
                    'infinite'  => __('Infinite carousel'),
                ])
                ->default(array_map(function() {
                    return true;
                }, $optsions)),       
        ];
    } 

    /**
     * Serialize the widget fro display.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    {    
        return [  
            'carousel' => $this->carousel()->toArray(),
            'items' => $this->carousel()->items->map->toArray(),
            'optsions' => array_merge((array) $this->metaValue('options'), [
                'speed' => $this->metaValue('speed'),
            ]),
        ];
    } 

    /**
     * Query related tempaltes.
     * 
     * @param  [type] $request [description]
     * @param  [type] $query   [description]
     * @return [type]          [description]
     */
    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(SliderWidget::class);
    }  

    public function carousel()
    {
        return once(function() {
            return Carousel::newModel()->with([
                'items' => function($query) {
                    $query
                        ->with('media')
                        ->orderBy('order')
                        ->where(function($query) {
                            $query->whereNull('start_date')->orWhere('start_date', '<=', now());
                        })
                        ->where(function($query) {
                            $query->whereNull('end_date')->orWhere('end_date', '>', now());
                        });
                } 
            ])->find($this->metaValue('carousel'));
        });
    }   
}
