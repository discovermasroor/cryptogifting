<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactGuestListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_guest_lists', function (Blueprint $table) {
            $table->id();
            $table->string('contact_guest_list_id')->nullable()->unique();
            $table->string('guest_list_id')->nullable();
            $table->foreign('guest_list_id')->references('guest_list_id')->on('guest_lists')->onDelete('cascade')->update('cascade');
            $table->string('contact_id')->nullable();
            $table->foreign('contact_id')->references('contact_id')->on('contacts')->onDelete('cascade')->update('cascade');
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
        Schema::dropIfExists('contact_guest_list');
    }
}
