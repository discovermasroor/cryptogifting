<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatEventGuestGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_guest_groups', function (Blueprint $table) {
            $table->id();
            $table->string('event_guest_group_id')->nullable()->unique();
            // $table->string('guest_list_id')->nullable();
            // $table->foreign('guest_list_id')->references('guest_list_id')->on('guest_lists')->onDelete('cascade')->update('cascade');
            $table->string('event_id')->nullable();
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade')->update('cascade');
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_guest_groups');
    }
}
