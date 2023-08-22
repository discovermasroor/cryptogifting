<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('btc_rate')->default(0)->after('amount');
            $table->double('cg_platform_fee')->default(0)->after('btc_rate');
            $table->double('other_platform_fee')->default(0)->after('cg_platform_fee');
            $table->double('valr_transaction_fees')->default(0)->after('other_platform_fee');
            $table->double('zar_into_btc')->default(0)->after('valr_transaction_fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['btc_rate', 'cg_platform_fee', 'other_platform_fee', 'valr_transaction_fees', 'zar_into_btc']);
        });
    }
}
