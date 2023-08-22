<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherPlatformFeesColumnInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->double('other_platform_fees')->default(0)->after('fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->dropColumn('other_platform_fees');
        });
    }
}
