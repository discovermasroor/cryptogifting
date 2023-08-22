<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AddTwoRowsInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting();
        $setting->keys = 'valr_fast_fees';
        $setting->values = 5;
        $setting->save();
        
        $setting = new Setting();
        $setting->keys = 'valr_normal_fees';
        $setting->values = 5;
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('keys', '=', 'valr_fast_fees')->delete();
        Setting::where('keys', '=', 'valr_normal_fees')->delete();
    }
}
