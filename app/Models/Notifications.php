<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use Flagable;
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
