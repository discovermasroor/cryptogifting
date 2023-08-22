<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeneficiaryIdInWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallets', function (Blueprint $table) {
            $table->string('beneficiary_id')->nullable()->after('user_id');
            $table->foreign('beneficiary_id')->references('beneficiary_id')->on('beneficiaries')->onDelete('cascade')->update('cascade');
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
            $table->dropForeign('user_wallets_beneficiary_id_foreign');
            $table->dropColumn(['beneficiary_id']);
        });
    }
}
