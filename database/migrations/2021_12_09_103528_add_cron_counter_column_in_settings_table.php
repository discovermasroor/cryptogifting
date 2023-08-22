<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AddCronCounterColumnInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $setting = new Setting();
        $setting->keys = "cron_counter";
        $setting->values = "1";
        $setting->save();

        $setting = new Setting();
        $setting->keys = "valr_branch_code";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting();
        $setting->keys = "valr_account_number";
        $setting->values = "0";
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('keys', '=', 'cron_counter')->delete();
        Setting::where('keys', '=', 'valr_branch_code')->delete();
        Setting::where('keys', '=', 'valr_account_number')->delete();
    }
}
