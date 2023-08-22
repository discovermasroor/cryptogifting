<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInSiRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('si_records', function (Blueprint $table) {
            $table->longText('selfie')->nullable()->after('user_id');
            $table->string('id_card')->nullable()->after('selfie');
            $table->string('address_document')->nullable()->after('id_card');
            $table->string('bank_account_document')->nullable()->after('address_document');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('si_records', function (Blueprint $table) {
            $table->dropColumn(['selfie', 'id_card', 'address_document', 'bank_account_document']);
        });
    }
}
