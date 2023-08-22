<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSomeColumnsInWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string('smile_job_id')->nullable()->after('beneficiary_id');
            $table->foreign('smile_job_id')->references('si_id')->on('si_records')->onDelete('cascade')->update('cascade');
            $table->string('account_type')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_type');
            $table->string('branch_code')->nullable()->after('account_number');
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
            $table->dropForeign('withdrawals_smile_job_id_foreign');
            $table->dropColumn(['smile_job_id', 'account_type', 'account_number', 'branch_code']);
        });
    }
}
