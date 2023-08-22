<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->nullable()->unique();
            $table->string('creator_id')->nullable();
            $table->foreign('creator_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('theme_id')->nullable();
            $table->foreign('theme_id')->references('theme_id')->on('event_themes')->onDelete('cascade')->update('cascade');
            $table->string('event_link')->nullable();
            $table->string('name')->nullable();
            $table->string('hosted_by')->nullable();
            $table->date('event_date')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['virtual', 'physical',  'no_event'])->nullable();
            $table->double('amount')->default(0);
            $table->double('bitcoin_allocation')->default(0);
            $table->double('ethirium_allocation')->default(0);
            $table->enum('rsvp', ['yes',  'no', 'maybe'])->nullable();
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
        Schema::dropIfExists('events');
    }
}
