<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class ContactGuestList extends Model
{
    use Flagable;
    protected $table = 'contact_guest_lists';
    protected $primaryKey = 'contact_guest_list_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function contact_user ()
    {
        return $this->hasOne('\App\Models\Contact', 'contact_id', 'contact_id');
    }
}
