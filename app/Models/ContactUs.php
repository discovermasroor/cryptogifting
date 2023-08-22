<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use Flagable;
    protected $table = 'contact_us';
    protected $primaryKey = 'contact_us_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['contact_us', 'loyalty_program', 'feedback', 'affiliates', 'read', 'login_or_not', 'file_url'];

    public const FLAG_CONTACT_US = 1;
    public const FLAG_LOYALTY_PROGRAM = 2;
    public const FLAG_FEEDBACK = 4;
    public const FLAG_AFFILIATE = 8;
    public const FLAG_READ = 16;
    public const FLAG_LOGIN_OR_NOT = 32;

    public function getContactUsAttribute() {
        return ($this->flags & self::FLAG_CONTACT_US) == self::FLAG_CONTACT_US;
    }

    public function getLoyaltyProgramAttribute() {
        return ($this->flags & self::FLAG_LOYALTY_PROGRAM) == self::FLAG_LOYALTY_PROGRAM;
    }

    public function getFeedbackAttribute() {
        return ($this->flags & self::FLAG_FEEDBACK) == self::FLAG_FEEDBACK;
    }

    public function getAffiliatesAttribute() {
        return ($this->flags & self::FLAG_AFFILIATE) == self::FLAG_AFFILIATE;
    }

    public function getReadAttribute() {
        return ($this->flags & self::FLAG_READ) == self::FLAG_READ;
    }
    
    public function getLoginOrNotAttribute() {
        return ($this->flags & self::FLAG_LOGIN_OR_NOT) == self::FLAG_LOGIN_OR_NOT;
    }

    public function customer ()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'submitted_user_id');
    }
    
    public function getFileUrlAttribute ()
    {
        if ($this->file) {
            return url('/').'/public/storage/contact-us/'.$this->contact_us_id.'/'.$this->file;

        }
        return null;
    }
}
