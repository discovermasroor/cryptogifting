<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNationalIdColumnFromSidRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('si_records', function (Blueprint $table) {
            $table->dropColumn(['id_card']);
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
            $table->string('id_card')->nullable()->after('selfie');
        });
    }
}
