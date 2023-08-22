<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAmountWithTaxInEventAcceptance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->double('amount_tax')->default(0)->after('amount'); 
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
            $table->dropColumn(['amount_tax']);
        });
    }
}
