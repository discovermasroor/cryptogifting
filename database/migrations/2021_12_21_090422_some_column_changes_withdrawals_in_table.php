<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeColumnChangesWithdrawalsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['account_type', 'account_number', 'branch_code', 'amount', 'bank_name']);
            $table->string('bank_detail_id')->nullable()->after('smile_job_id');
            $table->foreign('bank_detail_id')->references('bank_detail_id')->on('bank_details')->onDelete('cascade')->update('cascade');
            $table->double('requested_amount')->default(0)->after('currency');
            $table->double('remaining_amount')->default(0)->after('requested_amount');
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
            $table->string('bank_name')->nullable()->after('smile_job_id');
            $table->string('account_type')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_type');
            $table->string('branch_code')->nullable()->after('account_number');
            $table->string('amount')->nullable()->after('branch_code');
            $table->dropForeign('withdrawals_bank_detail_id_foreign');
            $table->dropColumn(['requested_amount', 'bank_detail_id', 'remaining_amount']);
        });
    }
}
