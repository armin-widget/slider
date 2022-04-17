<?php

namespace Armincms\Widgets\Slider\Nova;
   
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea; 

class CarouselItem extends Resource
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Widgets\Slider\Models\CarouselItem::class;

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

            BelongsTo::make(__('Carousel'), 'carousel', Carousel::class)
                ->required()
                ->rules('required')
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Select::make(__('Carousel Target'), 'target')
                ->options([
                    '_self' => __('Open carousel in current tab'),
                    '_blank' => __('Open carousel in new tab'),
                    '_same' => __('Open carousel in same tab'),
                ])
                ->rules('required')
                ->required()
                ->hideFromIndex(),

            Text::make(__('Carousel Item Title'), 'title')
                ->nullable()
                ->rules('max:250'), 

            Text::make(__('Carousel Item Link'), 'link')
                ->nullable()
                ->rules('max:250')
                ->hideFromIndex(), 

            Number::make(__('Carousel Item Order'), 'order')
                ->default(0)
                ->min(0)
                ->max(99) 
                ->required() 
                ->rules('required'), 

            $this->datetimeField(__('Carousel start date'), 'start_date')
                 ->nullable()
                 ->hideFromIndex(),
            $this->datetimeField(__('Carousel end date'), 'end_date') 
                 ->hideFromIndex()
                 ->nullable(),

            Textarea::make(__('Carousel Item Caption'), 'caption')
                ->nullable()
                ->rules('max:250')
                ->hideFromIndex(), 

            $this->medialibrary(__('Carousel Item Image'), 'image')
                ->required()
                ->rules('required'),
        ];
    }  
}
