<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestListIdInEventGuestGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_guest_groups', function (Blueprint $table) {
            $table->string('guest_list_id')->nullable()->after('event_id');
            $table->foreign('guest_list_id')->references('guest_list_id')->on('guest_lists')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_guest_groups', function (Blueprint $table) {
            $table->dropForeign('event_guest_groups_guest_list_id_foreign');
            $table->dropColumn('guest_list_id');
        });
    }
}
