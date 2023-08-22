<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class Withdrawal extends Model
{
    use Flagable;
    protected $table = 'withdrawals';
    protected $primaryKey = 'withdrawal_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['in_progress', 'completed', 'failed', 'fast', 'sent_to_client'];

    public const FLAG_PROGRESS = 1;
    public const FLAG_COMPLETED = 2;
    public const FLAG_FAILED = 4;
    public const FLAG_FAST = 8;
    public const FLAG_SENT_TO_CLIENT = 16;

    public function getInProgressAttribute() {
        return ($this->flags & self::FLAG_PROGRESS) == self::FLAG_PROGRESS;
    }

    public function getCompletedAttribute() {
        return ($this->flags & self::FLAG_COMPLETED) == self::FLAG_COMPLETED;
    }

    public function getFailedAttribute() {
        return ($this->flags & self::FLAG_FAILED) == self::FLAG_FAILED;
    }

    public function getFastAttribute() {
        return ($this->flags & self::FLAG_FAST) == self::FLAG_FAST;
    }

    public function getSentToClientAttribute() {
        return ($this->flags & self::FLAG_SENT_TO_CLIENT) == self::FLAG_SENT_TO_CLIENT;
    }

    public function user_wallet () {
        return $this->hasOne('App\Models\UserWallet', 'user_wallet_id', 'user_wallet_id');
    }

    public function customer () {
        return $this->hasOne('App\Models\User', 'user_id', 'user_id');
    }

    public function beneficiar () {
        return $this->hasOne('App\Models\Beneficiar', 'beneficiary_id', 'beneficiary_id');
    }

    public function bank_info () {
        return $this->hasOne('App\Models\BankDetail', 'bank_detail_id', 'bank_detail_id');
    }
}
