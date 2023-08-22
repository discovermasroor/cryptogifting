<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Beneficiar extends Model
{
    use Flagable;
    protected $table = 'beneficiaries';
    protected $primaryKey = 'beneficiary_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
