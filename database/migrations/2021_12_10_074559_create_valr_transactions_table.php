<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValrTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valr_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('valr_transaction_id')->nullable()->unique();
            $table->string('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('beneficiary_id')->on('beneficiaries')->onDelete('cascade')->update('cascade');
            $table->string('currency')->nullable();
            $table->string('amount')->nullable();
            $table->longText('response')->nullable();
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
        Schema::dropIfExists('valr_transactions');
    }
}
