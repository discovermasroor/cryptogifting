<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSomeColumnsInWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign('withdrawals_smile_job_id_foreign');
            $table->dropColumn(['smile_job_id', 'valr_fees', 'valr_transaction_fees', 'vat_tax_percentage', 'vat_tax_amount', 'cg_platfrom_fees', 'requested_amount_by_user', 'remaining_amount']);
            $table->double('total_deducted_amount')->default(0)->after('requested_amount');
            $table->string('cg_platform_fees')->nullable()->after('total_deducted_amount');
            $table->string('cg_platform_fees_type')->nullable()->after('cg_platform_fees');
            $table->double('cg_platform_fees_share')->default(0)->after('cg_platform_fees_type');

            $table->double('vat_tax')->default(0)->after('cg_platform_fees_share');
            $table->string('vat_tax_type')->nullable()->after('vat_tax');
            $table->double('vat_tax_share')->default(0)->after('vat_tax_type');

            $table->double('valr_taker')->default(0)->after('vat_tax_share');
            $table->string('valr_taker_type')->nullable()->after('valr_taker');
            $table->double('valr_taker_share')->default(0)->after('valr_taker_type');

            $table->double('valr_withdrawal_fees')->default(0)->after('valr_taker_share');
            $table->string('valr_withdrawal_fees_type')->nullable()->after('valr_withdrawal_fees');
            $table->double('valr_withdrawal_fees_share')->default(0)->after('valr_withdrawal_fees_type');

            $table->double('bank_charges')->default(0)->after('valr_withdrawal_fees_share');
            $table->string('bank_charges_type')->nullable()->after('bank_charges');
            $table->double('bank_charges_share')->default(0)->after('bank_charges_type');

            $table->double('all_charged_fees_in_zar')->default(0)->after('bank_charges_share');
            $table->double('final_amount_in_btc')->default(0)->after('all_charged_fees_in_zar');
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
            $table->dropColumn(['total_deducted_amount', 'vat_tax', 'vat_tax_type', 'vat_tax_share', 'valr_taker', 'valr_taker_type', 'valr_taker_share', 'valr_withdrawal_fees', 'valr_withdrawal_fees_type', 'valr_withdrawal_fees_share', 'bank_charges', 'bank_charges_type', 'bank_charges_share', 'cg_platform_fees_type', 'cg_platform_fees_share', 'cg_platform_fees', 'all_charged_fees_in_zar', 'final_amount_in_btc']);
            $table->string('smile_job_id')->nullable()->after('beneficiary_id');
            $table->foreign('smile_job_id')->references('si_id')->on('si_records')->onDelete('cascade')->update('cascade');
            $table->double('valr_fees')->default(0);
            $table->double('valr_transaction_fees')->default(0);
            $table->double('vat_tax_percentage')->default(0);
            $table->double('vat_tax_amount')->default(0);
            $table->double('requested_amount_by_user')->default(0);
            $table->double('remaining_amount')->default(0);
            $table->double('cg_platfrom_fees')->default(0);
        });
    }
}
