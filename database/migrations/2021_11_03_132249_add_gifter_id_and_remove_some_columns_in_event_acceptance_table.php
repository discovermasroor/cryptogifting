<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGifterIdAndRemoveSomeColumnsInEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_acceptance', function (Blueprint $table) {
            $table->dropForeign('event_acceptance_user_id_foreign');
            $table->dropColumn(['bitcoin_allocation', 'ethirium_allocation', 'user_id', 'relation_ship']);
            $table->string('receiver_id')->nullable()->after('event_id');
            $table->foreign('receiver_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('gifter_id')->nullable()->after('user_id');
            $table->foreign('gifter_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
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
            $table->dropForeign('event_acceptance_gifter_id_foreign');
            $table->dropForeign('event_acceptance_receiver_id_foreign');
            $table->dropColumn(['receiver_id', 'gifter_id']);
            $table->string('user_id')->nullable()->after('event_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->double('bitcoin_allocation')->default(0)->after('user_id');
            $table->double('ethirium_allocation')->default(0)->after('bitcoin_allocation');
            $table->string('relation_ship')->nullable()->after('ethirium_allocation');
        });
    }
}
