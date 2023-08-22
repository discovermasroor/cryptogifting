<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class ChangeSomeRowsInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            Setting::where('keys', '=', 'valr_withdrawal_fees')->orWhere('keys', '=', 'valr_withdrawal_fees_type')->delete();

            $setting = new Setting();
            $setting->keys = 'valr_fast_fees_type';
            $setting->values = "fixed";
            $setting->save();

            $setting = new Setting();
            $setting->keys = 'valr_normal_fees_type';
            $setting->values = "fixed";
            $setting->save();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $setting = new Setting();
            $setting->keys = 'valr_withdrawal_fees';
            $setting->values = "10";
            $setting->save();
            
            $setting = new Setting();
            $setting->keys = 'valr_withdrawal_fees_type';
            $setting->values = "fixed";
            $setting->save();
            Setting::where('keys', '=', 'valr_normal_fees_type')->orWhere('keys', '=', 'valr_fast_fees_type')->delete();
        });
    }
}
