<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class EventAcceptance extends Model
{
    use Flagable;
    protected $table = 'event_acceptance';
    protected $primaryKey = 'event_acceptance_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['own_gift', 'no_gift', 'amount_gift', 'paid', 'guest_gift', 'sent_to_exchange', 'complete_transaction'];

    public const FLAG_OWN_GIFT = 1;
    public const FLAG_NO_GIFT = 2;
    public const FLAG_AMOUNT_GIFT = 4;
    public const FLAG_PAID = 8;
    public const FLAG_GUEST_GIFT = 16;
    public const FLAG_SENT_TO_EXCHANGE = 32;
    public const FLAG_COMPLETE_TRANSACTION = 64;

    public function getOwnGiftAttribute() {
        return ($this->flags & self::FLAG_OWN_GIFT) == self::FLAG_OWN_GIFT;
    }

    public function getNoGiftAttribute() {
        return ($this->flags & self::FLAG_NO_GIFT) == self::FLAG_NO_GIFT;
    }

    public function getAmountGiftAttribute() {
        return ($this->flags & self::FLAG_AMOUNT_GIFT) == self::FLAG_AMOUNT_GIFT;
    }

    public function getPaidAttribute() {
        return ($this->flags & self::FLAG_PAID) == self::FLAG_PAID;
    }

    public function getGuestGiftAttribute() {
        return ($this->flags & self::FLAG_GUEST_GIFT) == self::FLAG_GUEST_GIFT;
    }

    public function getSentToExchangeAttribute() {
        return ($this->flags & self::FLAG_SENT_TO_EXCHANGE) == self::FLAG_SENT_TO_EXCHANGE;
    }

    public function getCompleteTransactionAttribute() {
        return ($this->flags & self::FLAG_COMPLETE_TRANSACTION) == self::FLAG_COMPLETE_TRANSACTION;
    }

    
    public function event_info() {
        return $this->hasOne('\App\Models\Event', 'event_id', 'event_id');
    }

    public function gifter() {
        return $this->hasOne('\App\Models\User', 'user_id', 'gifter_id');
    }

    public function beneficiary() {
        return $this->hasOne('\App\Models\Beneficiar', 'beneficiary_id', 'beneficiary_id');
    }

    public function transaction_details() {
        return $this->hasOne('\App\Models\Transaction', 'event_acceptance_id', 'event_acceptance_id');
    }

    public function gift_event_info () {
        return $this->hasOne('\App\Models\GifterEvent', 'gifter_event_id', 'gifter_event_id');
    }
}
