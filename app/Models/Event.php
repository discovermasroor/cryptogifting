<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Flagable;
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['flags'];
    protected $appends = ['live', 'unpublished', 'cancelled', 'past'];

    public const FLAG_LIVE = 1;
    public const FLAG_UNPUBLISHED = 2;
    public const FLAG_CANCELLED = 4;
    public const FLAG_PAST = 8;

    public function getLiveAttribute() {
        return ($this->flags & self::FLAG_LIVE) == self::FLAG_LIVE;
    }

    public function getUnpublishedAttribute() {
        return ($this->flags & self::FLAG_UNPUBLISHED) == self::FLAG_UNPUBLISHED;
    }

    public function getCancelledAttribute() {
        return ($this->flags & self::FLAG_CANCELLED) == self::FLAG_CANCELLED;
    }

    public function getPastAttribute() {
        return ($this->flags & self::FLAG_PAST) == self::FLAG_PAST;
    }

    public function event_theme () {
        return $this->hasOne('\App\Models\EventTheme', 'theme_id', 'theme_id');
    }

    public function event_creator () {
        return $this->hasOne('\App\Models\User', 'user_id', 'creator_id');
    }

    public function event_beneficiar () {
        return $this->hasOne('\App\Models\Beneficiar', 'beneficiary_id', 'beneficiary_id');
    }

    public function gifts () {
        return $this->hasMany('\App\Models\EventAcceptance', 'event_id', 'event_id');
    }
}
