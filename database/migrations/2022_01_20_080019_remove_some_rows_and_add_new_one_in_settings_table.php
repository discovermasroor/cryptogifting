<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class RemoveSomeRowsAndAddNewOneInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::where('keys', '=', 'platform_fee')->orWhere('keys', '=', 'other_platform_fee')->orWhere('keys', '=', 'valr_transaction_fees')->orWhere('keys', '=', 'vat_tax')->delete();
        
        $setting = new Setting();
        $setting->keys = 'platform_fee_gift';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'platform_fee_gift_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_maker_gifter';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_maker_gifter_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'callpay_handling_fee_gifter';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'callpay_handling_fee_gifter_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'callpay_contigency_fee_gifter';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'callpay_contigency_fee_gifter_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'vat_tax_gift';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'vat_tax_gift_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'cg_withdrawal_fees';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'cg_withdrawal_fees_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_taker_withdrawal_fees';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_taker_withdrawal_fees_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_withdrawal_fees';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_withdrawal_fees_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'mercantile_withdrawal_fees';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'mercantile_withdrawal_fees_type';
        $setting->values = "fixed";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'vat_tax_withdrawal';
        $setting->values = "10";
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'vat_tax_withdrawal_type';
        $setting->values = "fixed";
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $setting = new Setting();
        $setting->keys = 'platform_fee';
        $setting->values = 5;
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'other_platform_fee';
        $setting->values = 5;
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'vat_tax';
        $setting->values = "12";
        $setting->save();

        $setting = new Setting();
        $setting->keys = 'valr_transaction_fees';
        $setting->values = "0.12";
        $setting->save();
        
        $keys = array("platform_fee_gift", "platform_fee_gift_type", "valr_maker_gifter", "valr_maker_gifter_type", "callpay_handling_fee_gifter", "callpay_handling_fee_gifter_type", "callpay_contigency_fee_gifter", "callpay_contigency_fee_gifter_type", "vat_tax_gift", "vat_tax_gift_type", "cg_withdrawal_fees", "cg_withdrawal_fees_type", "valr_taker_withdrawal_fees", "valr_taker_withdrawal_fees_type", "valr_withdrawal_fees", "valr_withdrawal_fees_type", "mercantile_withdrawal_fees", "mercantile_withdrawal_fees_type", "vat_tax_withdrawal", "vat_tax_withdrawal_type");
        Setting::whereIn('keys', $keys)->delete();

    }
}
