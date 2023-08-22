<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use Flagable;

    protected $table = 'notification_users';
    protected $primaryKey = 'notification_user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [ 'flags'];

    protected $appends = ['read'];

    public const FLAG_READ = 1;

    public function getReadAttribute() {
        return ($this->flags & self::FLAG_READ) == self::FLAG_READ;
    }

    public function notification () {
        return $this->hasOne('\App\Models\Notifications', 'notification_id', 'notification_id');
    }
}
