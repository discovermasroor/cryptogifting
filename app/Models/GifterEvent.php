<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class GifterEvent extends Model
{
    use Flagable;
    protected $table = 'gifter_events';
    protected $primaryKey = 'gifter_event_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['active', 'get_crypto', 'gift_crypto'];

    public const FLAG_ACTIVE = 1;
    public const FLAG_GET_CRYPTO = 2;
    public const FLAG_GIFT_CRYPTO = 4;

    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getGetCryptoAttribute()
    {
        return ($this->flags & self::FLAG_GET_CRYPTO) == self::FLAG_GET_CRYPTO;
    }

    public function getGiftCryptoAttribute()
    {
        return ($this->flags & self::FLAG_GIFT_CRYPTO) == self::FLAG_GIFT_CRYPTO;
    }

    public function event_theme () {
        return $this->hasOne('\App\Models\EventTheme', 'theme_id', 'theme_id');
    }

    public function recipient () {
        return $this->hasOne('\App\Models\User', 'user_id', 'recipient_id');
    }

    public function sender () {
        return $this->hasOne('\App\Models\User', 'user_id', 'sender_id');
    }

    public function event_acceptance () {
        return $this->hasOne('\App\Models\EventAcceptance', 'gifter_event_id', 'gifter_event_id');
    }
}
