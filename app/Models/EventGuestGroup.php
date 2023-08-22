<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class EventGuestGroup extends Model
{
    use Flagable;
    protected $table = 'event_guest_groups';
    protected $primaryKey = 'event_guest_group_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
