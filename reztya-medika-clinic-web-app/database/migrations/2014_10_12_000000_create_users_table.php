<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->foreignId('user_role_id')->default(2); // 1 = admin, 2 =  user
            $table->string('username');
            $table->string('name');
            $table->date('birthdate');
            $table->string('phone');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_picture')->default('profile-images/profile_picture_default.jpg');
            $table->boolean('is_banned')->default(false); // false = not banned, true = banned
            $table->integer('city_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
};
