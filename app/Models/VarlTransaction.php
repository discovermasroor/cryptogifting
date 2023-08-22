<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class VarlTransaction extends Model
{
    use Flagable;
    protected $table = 'valr_transactions';
    protected $primaryKey = 'valr_transaction_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
