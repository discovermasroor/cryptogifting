<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestWithdrawal extends Model
{
    use Flagable, SoftDeletes;
    protected $table = 'request_withdrawal';
    protected $primaryKey = 'withdrawal_request_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['process', 'completed'];

    public const FLAG_PROCESS = 1;
    public const FLAG_COMPLETE = 2;

    //only push this code

    public function getProcessAttribute() {
        return ($this->flags & self::FLAG_PROCESS) == self::FLAG_PROCESS;
    }

    public function getCompletedAttribute() {
        return ($this->flags & self::FLAG_COMPLETE) == self::FLAG_COMPLETE;
    }
}
