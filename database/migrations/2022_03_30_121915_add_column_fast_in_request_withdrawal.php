<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFastInRequestWithdrawal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_withdrawal', function (Blueprint $table) {
            $table->boolean('withdrawal_type')->default(0)->after('request_amount'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_withdrawal', function (Blueprint $table) {
            $table->dropColumn(['withdrawal_type']);
        });
    }
}
