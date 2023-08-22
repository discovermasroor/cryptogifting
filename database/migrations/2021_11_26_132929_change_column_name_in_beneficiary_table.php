<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNameInBeneficiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->renameColumn('valr_zar_wallet_id', 'valr_account_id');
            $table->dropColumn('valr_btc_wallet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->renameColumn( 'valr_account_id', 'valr_zar_wallet_id');
            $table->text('valr_btc_wallet_id')->nullable()->after('relation');
        });
    }
}
