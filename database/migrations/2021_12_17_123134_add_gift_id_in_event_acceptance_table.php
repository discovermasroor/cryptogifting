<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiftIdInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->string('gifter_event_id')->nullable()->after('event_id');
            $table->foreign('gifter_event_id')->references('gifter_event_id')->on('gifter_events')->onDelete('cascade')->update('cascade');
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
            $table->dropForeign('event_acceptance_gifter_event_id_foreign');
            $table->dropColumn(['gifter_event_id']);
        });
    }
}
