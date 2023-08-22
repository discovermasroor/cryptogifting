<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_sender_id_foreign');
            $table->dropForeign('transactions_user_id_foreign');
            $table->dropColumn(['user_id', 'sender_id', 'bank_name']);
            $table->string('withdrawal_id')->nullable()->after('event_acceptance_id');
            $table->foreign('withdrawal_id')->references('withdrawal_id')->on('withdrawals')->onDelete('cascade')->update('cascade');
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
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('sender_id')->nullable()->after('user_id');
            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
            $table->string('bank_name')->nullable();
            $table->dropForeign('transactions_withdrawal_id_foreign');
            $table->dropColumn(['withdrawal_id']);
        });
    }
}
