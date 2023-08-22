<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class EventTheme extends Model
{
    use Flagable;
    protected $table = 'event_themes';
    protected $primaryKey = 'theme_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['active', 'cover_image_url', 'gifter_image_url', 'event_card', 'gifter_card'];
    public const FLAG_ACTIVE = 1;
    public const FLAG_EVENT_CARD = 2;
    public const FLAG_GIFTER_CARD = 4;

    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }
    
    public function getEventCardAttribute()
    {
        return ($this->flags & self::FLAG_EVENT_CARD) == self::FLAG_EVENT_CARD;
    }

    public function getGifterCardAttribute()
    {
        return ($this->flags & self::FLAG_GIFTER_CARD) == self::FLAG_GIFTER_CARD;
    }

    public function getCoverImageUrlAttribute ()
    {
        if ($this->front_image) {
            return url('/').'/public/storage/themes/'.$this->theme_id.'/'.$this->front_image;

        }
        return null;
    }

    public function getGifterImageUrlAttribute ()
    {
        if ($this->gifter_image) {
            return url('/').'/public/storage/themes/'.$this->theme_id.'/'.$this->gifter_image;

        }
        return null;
    }
}
