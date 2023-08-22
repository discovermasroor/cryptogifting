<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AddFieldsInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting();
        $setting->keys = 'maximum_events';
        $setting->values = 50;
        $setting->save();

        $setting = new Setting();
        $setting->keys = 'maximum_gift_value';
        $setting->values = 20000.00;
        $setting->save();

        $setting = new Setting();
        $setting->keys = 'single_gift_per_event';
        $setting->values = true;
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('keys', '=', 'maximum_events')->delete();
        Setting::where('keys', '=', 'maximum_gift_value')->delete();
        Setting::where('keys', '=', 'single_gift_per_event')->delete();
    }
}
