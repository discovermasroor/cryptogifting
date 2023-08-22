<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->double('btc_zar_rate')->default(0)->after('remaining_amount');
            $table->double('valr_fees')->default(0)->after('btc_zar_rate');
            $table->double('valr_transaction_fees')->default(0)->after('valr_fees');
            $table->double('requested_amount_by_user')->default(0)->after('valr_transaction_fees');
            $table->double('cg_platfrom_fees')->default(0)->after('requested_amount_by_user');
            $table->double('requested_amount_by_user_in_zar')->default(0)->after('cg_platfrom_fees');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['btc_zar_rate', 'valr_fees', 'valr_transaction_fees', 'requested_amount_by_user', 'cg_platfrom_fees', 'requested_amount_by_user_in_zar']);
        });
    }
}
