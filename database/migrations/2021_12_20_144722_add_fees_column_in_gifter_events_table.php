<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeesColumnInGifterEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gifter_events', function (Blueprint $table) {
            $table->double('fees')->default(0)->after('gift_btc_amount');
        });

        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->double('fees')->default(0)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gifter_events', function (Blueprint $table) {
            $table->dropColumn('fees');
        });

        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->dropColumn('fees');
        });
    }
}
