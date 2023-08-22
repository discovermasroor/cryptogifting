<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInUserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallets', function (Blueprint $table) {
            $table->double('paid_amount')->default(0)->after('user_id');
            $table->string('paid_currency')->default(0)->after('paid_amount');
            $table->double('received_amount')->default(0)->after('paid_currency');
            $table->string('received_currency')->default(0)->after('received_amount');
            $table->double('fee_amount')->default(0)->after('received_currency');
            $table->string('fee_currency')->default(0)->after('fee_amount');
            $table->double('final_amount')->default(0)->after('fee_currency');
            $table->string('mode')->nullable()->after('final_amount');
            $table->longText('response')->nullable()->after('mode');
            $table->dropColumn(['type', 'amount']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_wallets', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'paid_currency', 'received_amount', 'received_currency', 'fee_amount', 'fee_currency', 'final_amount', 'mode', 'response']);
            $table->enum('type', ['bitcoin', 'etherium',  'zar'])->nullable()->after('user_id');
            $table->double('amount')->default(0)->after('type');
        });
    }
}
