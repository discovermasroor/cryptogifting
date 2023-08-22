<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_lists', function (Blueprint $table) {
            $table->id();
            $table->string('guest_list_id')->nullable()->unique();
            $table->string('creator_id')->nullable();
            $table->foreign('creator_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('beneficiary_id')->on('beneficiaries')->onDelete('cascade')->update('cascade');
            $table->enum('event_type', ['virtual',  'physical', 'no_event'])->nullable();
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
        Schema::dropIfExists('guest_lists');
    }
}
