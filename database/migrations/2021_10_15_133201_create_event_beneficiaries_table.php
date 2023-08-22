<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('event_beneficiary_id')->nullable()->unique();
            $table->string('event_id')->nullable();
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade')->update('cascade');
            $table->string('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('beneficiary_id')->on('beneficiaries')->onDelete('cascade')->update('cascade');
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
        Schema::dropIfExists('event_beneficiaries');
    }
}
