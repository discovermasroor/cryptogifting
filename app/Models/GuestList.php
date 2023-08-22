<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class GuestList extends Model
{
    use Flagable;
    protected $table = 'guest_lists';
    protected $primaryKey = 'guest_list_id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $appends = ['active', 'pending', 'cancelled', 'blocked'];

    public const FLAG_ACTIVE = 1;
    public const FLAG_PENDING = 2;
    public const FLAG_CANCELLED = 4;
    public const FLAG_BLOCKED = 8;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getPendingAttribute() {
        return ($this->flags & self::FLAG_PENDING) == self::FLAG_PENDING;
    }

    public function getCancelledAttribute() {
        return ($this->flags & self::FLAG_CANCELLED) == self::FLAG_CANCELLED;
    }

    public function getBlockedAttribute() {
        return ($this->flags & self::FLAG_BLOCKED) == self::FLAG_BLOCKED;
    }

    public function beneficiary ()
    {
        return $this->hasOne('\App\Models\Beneficiar', 'beneficiary_id', 'beneficiary_id');
    }
}
