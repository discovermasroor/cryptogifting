<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFullImageColumnInThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_themes', function (Blueprint $table) {
            $table->dropColumn(['full_image']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_themes', function (Blueprint $table) {
            $table->string('full_image')->nullable()->after('front_image');
        });
    }
}
