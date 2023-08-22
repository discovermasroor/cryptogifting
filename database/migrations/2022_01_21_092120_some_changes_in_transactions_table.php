<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeChangesInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_withdrawal_id_foreign');
            $table->dropColumn(['withdrawal_id', 'other_platform_fee', 'valr_transaction_fees', 'vat_tax_percentage', 'vat_tax_amount', 'type']);
            $table->string('cg_platform_fee_type')->nullable()->after('cg_platform_fee');
            $table->double('cg_platform_fee_share')->default(0)->after('cg_platform_fee_type');

            $table->double('vat_tax')->default(0)->after('cg_platform_fee_share');
            $table->string('vat_tax_type')->nullable()->after('vat_tax');
            $table->double('vat_tax_share')->default(0)->after('vat_tax_type');

            $table->double('valr_maker')->default(0)->after('vat_tax_share');
            $table->string('valr_maker_type')->nullable()->after('valr_maker');
            $table->double('valr_maker_share')->default(0)->after('valr_maker_type');

            $table->double('callpay_handling')->default(0)->after('valr_maker_share');
            $table->string('callpay_handling_type')->nullable()->after('callpay_handling');
            $table->double('callpay_handling_share')->default(0)->after('callpay_handling_type');

            $table->double('callpay_contigency')->default(0)->after('callpay_handling_share');
            $table->string('callpay_contigency_type')->nullable()->after('callpay_contigency');
            $table->double('callpay_contigency_share')->default(0)->after('callpay_contigency_type');

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
            $table->dropColumn(['vat_tax', 'vat_tax_type', 'vat_tax_share', 'valr_maker', 'valr_maker_type', 'valr_maker_share', 'callpay_handling', 'callpay_handling_type', 'callpay_handling_share', 'callpay_contigency', 'callpay_contigency_type', 'callpay_contigency_share', 'cg_platform_fee_type', 'cg_platform_fee_share']);
            $table->string('withdrawal_id')->nullable()->after('event_acceptance_id');
            $table->foreign('withdrawal_id')->references('withdrawal_id')->on('withdrawals')->onDelete('cascade')->update('cascade');
            $table->enum('type', ['withdraw',  'add'])->nullable();
            $table->double('other_platform_fee')->default(0)->after('cg_platform_fee');
            $table->double('valr_transaction_fees')->default(0)->after('other_platform_fee');
            $table->double('vat_tax_percentage')->default(0)->after('valr_transaction_fees');
            $table->double('vat_tax_amount')->default(0)->after('vat_tax_percentage');
        });
    }
}
