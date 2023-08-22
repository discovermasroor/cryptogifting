<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnEventBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_beneficiaries', function (Blueprint $table) {
            $table->string('user_id')->nullable()->after('beneficiary_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_beneficiaries', function (Blueprint $table) {
            $table->dropForeign('event_beneficiaries_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
