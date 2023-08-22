<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Flagable;
    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
