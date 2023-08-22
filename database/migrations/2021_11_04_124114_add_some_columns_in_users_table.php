<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('luno_bitcoin_account_id')->nullable()->after('image');
            $table->text('luno_etherium_account_id')->nullable()->after('luno_bitcoin_account_id');
            $table->text('luno_zar_account_id')->nullable()->after('luno_etherium_account_id');
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
            $table->dropColumn(['luno_bitcoin_account_id', 'luno_etherium_account_id', 'luno_zar_account_id']);
        });
    }
}
