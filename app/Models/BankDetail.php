<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankDetail extends Model
{
    use Flagable, SoftDeletes;
    protected $table = 'bank_details';
    protected $primaryKey = 'bank_detail_id';
    protected $keyType = 'string';
    public $incrementing = false;

    
}
