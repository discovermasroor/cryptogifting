<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSomeColumnsInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->dropForeign('event_acceptance_receiver_id_foreign');
            $table->dropColumn(['receiver_id', 'response']);
            $table->string('beneficiary_id')->nullable()->after('event_id');
            $table->foreign('beneficiary_id')->references('beneficiary_id')->on('beneficiaries')->onDelete('cascade')->update('cascade');
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
            $table->string('receiver_id')->nullable()->after('event_id');
            $table->foreign('receiver_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->text('response')->nullable()->after('rsvp');
            $table->dropForeign('event_acceptance_beneficiary_id_foreign');
            $table->dropColumn(['beneficiary_id']);
        });
    }
}
