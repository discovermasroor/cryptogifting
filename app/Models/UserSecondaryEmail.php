<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class UserSecondaryEmail extends Model
{
    use Flagable;
    protected $table = 'user_secondary_emails';
    protected $primaryKey = 'user_secondary_email_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
