<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnInBeneficiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->text('valr_btc_wallet_id')->nullable()->after('relation');
            $table->text('valr_zar_wallet_id')->nullable()->after('valr_btc_wallet_id');
            $table->dropColumn(['luno_bitcoin_account_id', 'luno_etherium_account_id', 'luno_zar_account_id']);
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
            $table->dropColumn(['valr_btc_wallet_id', 'valr_zar_wallet_id']);
            $table->text('luno_bitcoin_account_id')->nullable()->after('relation');
            $table->text('luno_etherium_account_id')->nullable()->after('luno_bitcoin_account_id');
            $table->text('luno_zar_account_id')->nullable()->after('luno_etherium_account_id');
        });
    }
}
