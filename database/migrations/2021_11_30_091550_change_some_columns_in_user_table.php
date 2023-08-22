<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSomeColumnsInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_document', 'address_document', 'bank_account_document']);
            $table->longText('selfie')->nullable()->after('reset_password_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('id_document')->nullable()->after('reset_password_token');
           $table->string('address_document')->nullable()->after('id_document');
           $table->string('bank_account_document')->nullable()->after('address_document');
           $table->dropColumn(['selfie']);
        });
    }
}
