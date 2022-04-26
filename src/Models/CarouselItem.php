<?php

namespace Armincms\Widgets\Slider\Models;
 
use Armincms\Contract\Concerns\InteractsWithMedia; 
use Armincms\Contract\Contracts\HasMedia; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CarouselItem extends Model implements HasMedia
{   
    use InteractsWithMedia; 
    use SoftDeletes;  

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [ 
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'order' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [ 'image' ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    { 
    }   

    /**
     * Get image converaions link.
     * 
     * @return array
     */
    public function getImageAttribute()
    {
        return $this->getFirstMediasWithConversions()->get('image');
    }
    
    /**
     * Query related Carousel.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function carousel()
    {
        return $this->belongsTo(Carousel::class);
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
            'target'      => $this->target,
            'title'      => $this->title,
            'link'      => $this->link,
            'order'      => $this->order,
            'caption'     => $this->caption,   
            'images'    => $this->getFirstMediasWithConversions()->get('image'),
        ];
    } 
}
