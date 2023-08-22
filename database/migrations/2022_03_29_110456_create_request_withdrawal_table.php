<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_withdrawal', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_request_id')->nullable()->unique();
            $table->string('user_id')->nullable();
            $table->string('beneficiary_id')->nullable();
            $table->string('bank_detail_id')->nullable();
            $table->string('request_amount')->nullable();
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
        Schema::dropIfExists('request_withdrawal');
    }
}
