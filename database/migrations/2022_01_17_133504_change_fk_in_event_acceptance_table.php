<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFkInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->string('contact_id')->nullable()->after('gifter_id');
            $table->foreign('contact_id')->references('contact_id')->on('contacts')->onDelete('cascade')->update('cascade');

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
            $table->dropForeign('event_acceptance_contact_id_foreign');
            $table->dropColumn(['contact_id']);
        });
    }
}
