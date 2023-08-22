<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AddCronStartTimeInSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        date_default_timezone_set('UTC');
        $date = date('Y-m-d h:i:s');
        $today_date = str_replace('+00:00', '.000Z', gmdate('c', strtotime($date)));    
        $setting = new Setting();
        $setting->keys = 'cron_start_time';
        $setting->values = $today_date;
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            Setting::where('keys', '=', 'cron_start_time')->delete();
        });
    }
}
