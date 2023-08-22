<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentForUserInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('id_document')->nullable()->after('reset_password_token');
           $table->string('address_document')->nullable()->after('id_document');
           $table->string('bank_account_document')->nullable()->after('address_document');
           $table->dropColumn(['luno_bitcoin_account_id', 'luno_etherium_account_id', 'luno_zar_account_id','google2fa_secret']);
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
            $table->dropColumn(['id_document', 'address_document', 'bank_account_document']);
             $table->text('luno_bitcoin_account_id')->nullable()->after('image');
            $table->text('luno_etherium_account_id')->nullable()->after('luno_bitcoin_account_id');
            $table->text('luno_zar_account_id')->nullable()->after('luno_etherium_account_id');
            $table->text('google2fa_secret')->nullable()->after('luno_bitcoin_account_id');
        });
    }
}
