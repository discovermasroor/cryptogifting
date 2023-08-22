<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_acceptance', function (Blueprint $table) {
            $table->id();
            $table->string('event_acceptance_id')->nullable()->unique();
            $table->string('event_id')->nullable();
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade')->update('cascade');
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->double('amount')->default(0);
            $table->double('bitcoin_allocation')->default(0);
            $table->double('ethirium_allocation')->default(0);
            $table->string('relation_ship')->nullable();
            $table->enum('rsvp', ['yes',  'no', 'maybe'])->nullable();
            $table->text('response')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_acceptance');
    }
}
