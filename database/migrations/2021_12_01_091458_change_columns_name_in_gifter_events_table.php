<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNameInGifterEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gifter_events', function (Blueprint $table) {
            $table->renameColumn('recipient_email', 'recipient_name');
            $table->renameColumn('sender_email', 'sender_name');
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
            $table->renameColumn('recipient_name', 'recipient_email');
            $table->renameColumn('sender_name', 'sender_email');
        });
    }
}
