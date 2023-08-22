<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable()->unique();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('country_code')->nullable();
            $table->double('phone')->nullable();
            $table->integer('email_verification_code')->default(0);
            $table->integer('phone_verification_code')->default(0);
            $table->string('image')->nullable();
            $table->text('device_token')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $admin = new User;
		$admin->user_id = (String) Str::uuid();
		$admin->username = 'admin';
		$admin->first_name = 'Admin';
		$admin->email = 'admin@gmail.com';
		$admin->password = Hash::make('123123');
		$admin->addFlag(User::FLAG_ACTIVE);
		$admin->addFlag(User::FLAG_ADMIN);
		$admin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
