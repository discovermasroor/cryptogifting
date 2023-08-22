<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGifterEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifter_events', function (Blueprint $table) {
            $table->id();
            $table->string('gifter_event_id')->unique();
            $table->string('theme_id')->nullable();
            $table->foreign('theme_id')->references('theme_id')->on('event_themes')->onDelete('cascade')->update('cascade');
            $table->string('sender_id')->nullable();
            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('recipient_id')->nullable();
            $table->foreign('recipient_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('sender_email')->nullable();
            $table->string('recipient_email')->nullable();
            $table->double('gift_zar_amount')->default(0);
            $table->double('gift_btc_amount')->default(0);
            $table->text('message')->nullable();
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
        Schema::dropIfExists('gifter_events');
    }
}
