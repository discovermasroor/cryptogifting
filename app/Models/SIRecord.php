<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class SIRecord extends Model
{
    use Flagable;
    protected $table = 'si_records';
    protected $primaryKey = 'si_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['pass', 'availed', 'bank_doc_url', 'address_doc_url'];

    public const FLAG_PASS = 1;
    public const FLAG_AVAILED = 2;

    public function getAvailedAttribute() {
        return ($this->flags & self::FLAG_AVAILED) == self::FLAG_AVAILED;
    }

    public function getPassAttribute() {
        return ($this->flags & self::FLAG_PASS) == self::FLAG_PASS;
    }

    public function getBankDocUrlAttribute() {
        if ($this->bank_account_document) {
            return url('/').'/public/storage/smilekyc-attempts/'.$this->si_id.'/'.$this->bank_account_document;

        }
        return null;
    }

    public function getAddressDocUrlAttribute() {
        if ($this->address_document) {
            return url('/').'/public/storage/smilekyc-attempts/'.$this->si_id.'/'.$this->address_document;

        }
        return null;
    }

}
