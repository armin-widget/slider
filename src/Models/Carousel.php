<?php

namespace Armincms\Widgets\Slider\Models;

use Armincms\Contract\Concerns\Configurable; 
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
}
