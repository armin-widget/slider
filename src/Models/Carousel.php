<?php

namespace Armincms\Widgets\Slider\Models;

use Armincms\Contract\Concerns\Configurable; 
use Armincms\Contract\Concerns\InteractsWithWidgets;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class Carousel extends Model
{  
    use Configurable;  
    use SoftDeletes;    
    
    /**
     * Query related CarouselItem.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function items()
    {
        return $this->hasMany(CarouselItem::class, 'carousel_id');
    }

    /**
     * Serialize the model to pass into the client view for single item.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForWidget($request)
    {
        return [
            'id'        => $this->getKey(),
            'name'      => $this->name,
            'items'     => $this->items->sortBy->order->map->serializeForWidget($request), 
        ];
    } 
}
