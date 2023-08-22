<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeChangesInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->dropColumn(['amount_inc_valr_fees', 'fees', 'other_platform_fees']);
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
            $table->double('amount_inc_valr_fees')->default(0)->after('amount');
            $table->double('fees')->default(0)->after('amount_inc_valr_fees');
            $table->double('other_platform_fees')->default(0)->after('fees');
        });
    }
}
