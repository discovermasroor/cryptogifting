<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class EventBeneficiar extends Model
{
    use Flagable;
    protected $table = 'event_beneficiaries';
    protected $primaryKey = 'event_beneficiary_id';
    protected $keyType = 'string';
    public $incrementing = false;

    
}
