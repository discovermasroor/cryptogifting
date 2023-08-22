<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventAcceptanceIdInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('event_acceptance_id')->nullable()->after('transaction_id');
            $table->foreign('event_acceptance_id')->references('event_acceptance_id')->on('event_acceptance')->onDelete('cascade')->update('cascade');
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
            //
            $table->dropForeign('transactions_event_acceptance_id_foreign');
            $table->dropColumn(['event_acceptance_id']);

        });
    }
}
