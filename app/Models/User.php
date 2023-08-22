<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Concerns\Flagable;

class User extends Authenticatable
{
    use Flagable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'password', 'flags'
    ];

    protected $appends = ['provisional_approval','approved_selfie', 'email_verified', '2fa', 'daily_summary', 'weekly_summary', 'monthly_summary', 'promotions', 'newsletters', 'opens_an_invite', 'rsvp_for_my_event', 'process_a_gift', 'resend_card', 'sends_reminder_of_event', 'send_thank_you_card', 'active', 'customer', 'admin', 'added_by_contact', 'added_by_beneficiary', 'user_image_url', 'domistic_politically','foreign_politically','user_national_document_url','gifter_user', 'answered_question', 'over_eighteen', 'bank_doc_url', 'address_doc_url'];

    public const FLAG_APPROVED_SELFIE = 1;
    public const FLAG_EMAIL_VERIFIED = 2;
    public const FLAG_TWO_FA = 4;
    public const FLAG_DAILY_SUMMARY = 8;
    public const FLAG_WEEKLY_SUMMARY = 16;
    public const FLAG_MONTHLY_SUMMARY = 32;
    public const FLAG_PROMOTIONS = 64;
    public const FLAG_NEWSLETTERS = 128;
    public const FLAG_OPENS_AN_INVITE = 256;
    public const FLAG_RESP_FOR_MY_EVENT = 512;
    public const FLAG_PROCESS_A_GIFT = 1024;
    public const FLAG_RESEND_CARD = 2048;
    public const FLAG_SENDS_REMINDER_OF_EVENT = 4096;
    public const FLAG_SENDS_THANKYOU_CARD = 8192;
    public const FLAG_ACTIVE = 16384;
    public const FLAG_CUSTOMER = 32768;
    public const FLAG_ADMIN = 65536;
    public const FLAG_ADDED_BY_CONTACT = 131072;
    public const FLAG_ADDED_BY_BENEFICIARY = 262144;
    public const FLAG_DOMISTIC_POLITICALLY = 524288;
    public const FLAG_FOREIGN_POLITICALLY = 1048576;
    public const FLAG_GIFTER_USER = 2097152;
    public const FLAG_PROVISIONAL_APPROVAL = 4194304;
    public const FLAG_ANSWERED_QUESTION = 8388608;
    public const FLAG_OVER_EIGHTEEN = 16777216;

    public function getOverEighteenAttribute() {
        return ($this->flags & self::FLAG_OVER_EIGHTEEN) == self::FLAG_OVER_EIGHTEEN;
    }

    public function getAnsweredQuestionAttribute() {
        return ($this->flags & self::FLAG_ANSWERED_QUESTION) == self::FLAG_ANSWERED_QUESTION;
    }

    public function getProvisionalApprovalAttribute() {
        return ($this->flags & self::FLAG_PROVISIONAL_APPROVAL) == self::FLAG_PROVISIONAL_APPROVAL;
    }

    public function getApprovedSelfieAttribute() {
        return ($this->flags & self::FLAG_APPROVED_SELFIE) == self::FLAG_APPROVED_SELFIE;
    }

    public function getAddedByBeneficiaryAttribute() {
        return ($this->flags & self::FLAG_ADDED_BY_BENEFICIARY) == self::FLAG_ADDED_BY_BENEFICIARY;
    }
    
    public function getEmailVerifiedAttribute() {
        return ($this->flags & self::FLAG_EMAIL_VERIFIED) == self::FLAG_EMAIL_VERIFIED;
    }

    public function get2faAttribute() {
        return ($this->flags & self::FLAG_TWO_FA) == self::FLAG_TWO_FA;
    }

    public function getDailySummaryAttribute() {
        return ($this->flags & self::FLAG_DAILY_SUMMARY) == self::FLAG_DAILY_SUMMARY;
    }

    public function getWeeklySummaryAttribute() {
        return ($this->flags & self::FLAG_WEEKLY_SUMMARY) == self::FLAG_WEEKLY_SUMMARY;
    }

    public function getMonthlySummaryAttribute() {
        return ($this->flags & self::FLAG_MONTHLY_SUMMARY) == self::FLAG_MONTHLY_SUMMARY;
    }

    public function getNewslettersAttribute() {
        return ($this->flags & self::FLAG_NEWSLETTERS) == self::FLAG_NEWSLETTERS;
    }

    public function getPromotionsAttribute() {
        return ($this->flags & self::FLAG_PROMOTIONS) == self::FLAG_PROMOTIONS;
    }

    public function getOpensAnInviteAttribute() {
        return ($this->flags & self::FLAG_OPENS_AN_INVITE) == self::FLAG_OPENS_AN_INVITE;
    }

    public function getRsvpForMyEventAttribute() {
        return ($this->flags & self::FLAG_RESP_FOR_MY_EVENT) == self::FLAG_RESP_FOR_MY_EVENT;
    }

    public function getProcessAGiftAttribute() {
        return ($this->flags & self::FLAG_PROCESS_A_GIFT) == self::FLAG_PROCESS_A_GIFT;
    }

    public function getResendCardAttribute() {
        return ($this->flags & self::FLAG_RESEND_CARD) == self::FLAG_RESEND_CARD;
    }

    public function getSendsReminderOfEventAttribute() {
        return ($this->flags & self::FLAG_SENDS_REMINDER_OF_EVENT) == self::FLAG_SENDS_REMINDER_OF_EVENT;
    }

    public function getSendThankYouCardAttribute() {
        return ($this->flags & self::FLAG_SENDS_THANKYOU_CARD) == self::FLAG_SENDS_THANKYOU_CARD;
    }

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getCustomerAttribute() {
        return ($this->flags & self::FLAG_CUSTOMER) == self::FLAG_CUSTOMER;
    }

    public function getAdminAttribute() {
        return ($this->flags & self::FLAG_ADMIN) == self::FLAG_ADMIN;
    }

    public function getAddedByContactAttribute() {
        return ($this->flags & self::FLAG_ADDED_BY_CONTACT) == self::FLAG_ADDED_BY_CONTACT;
    }

    public function getDomisticPoliticallyAttribute() {
        return ($this->flags & self::FLAG_DOMISTIC_POLITICALLY) == self::FLAG_DOMISTIC_POLITICALLY;
    }

    public function getForeignPoliticallyAttribute() {
        return ($this->flags & self::FLAG_FOREIGN_POLITICALLY) == self::FLAG_FOREIGN_POLITICALLY;
    }

    public function getGifterUserAttribute() {
        return ($this->flags & self::FLAG_GIFTER_USER) == self::FLAG_GIFTER_USER;
    }

    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    public function getUserImageUrlAttribute ()
    {
        return base_path().'/public/storage/users/'.$this->user_id.'/'.$this->image;
    }
    public function getUserNationalDocumentUrlAttribute ()
    {
        return base_path().'/public/storage/users/'.$this->user_id.'/'.$this->national_id_card;
    }

    public function getBankDocUrlAttribute() {
        if ($this->bank_account_document) {
            return url('/').'/public/storage/users/'.$this->user_id.'/'.$this->bank_account_document;

        }
        return null;
    }

    public function getAddressDocUrlAttribute() {
        if ($this->address_document) {
            return url('/').'/public/storage/users/'.$this->user_id.'/'.$this->address_document;

        }
        return null;
    }

    public function loginSecurity()
    {
        return $this->hasOne("App\Models\LoginSecurity",'user_id','user_id');
    }
    public function beneficiary()
    {
        return $this->hasOne("App\Models\Beneficiar",'user_id','user_id');
    }
}
