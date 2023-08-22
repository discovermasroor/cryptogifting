<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use Flagable;
    protected $table = 'user_wallets';
    protected $primaryKey = 'user_wallet_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['moved_to_subaccount', 'in_process', 'complete'];

    public const FLAG_MOVED_TO_SUBACCOUNT = 1;
    public const FLAG_IN_PROCESS = 2;
    public const FLAG_COMPLETE = 4;

    public function getMovedToSubaccountAttribute() {
        return ($this->flags & self::FLAG_MOVED_TO_SUBACCOUNT) == self::FLAG_MOVED_TO_SUBACCOUNT;
    }

    public function getInProcessAttribute() {
        return ($this->flags & self::FLAG_IN_PROCESS) == self::FLAG_IN_PROCESS;
    }

    public function getCompleteAttribute() {
        return ($this->flags & self::FLAG_COMPLETE) == self::FLAG_COMPLETE;
    }
}
