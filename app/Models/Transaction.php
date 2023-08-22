<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Flagable;
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['success', 'fail'];

    public const FLAG_SUCCESS = 1;
    public const FLAG_FAIL = 2;

    public function getSuccessAttribute() {
        return ($this->flags & self::FLAG_SUCCESS) == self::FLAG_SUCCESS;
    }

    public function getFailAttribute() {
        return ($this->flags & self::FLAG_FAIL) == self::FLAG_FAIL;
    }
}
