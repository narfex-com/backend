<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('inviter_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_2fa_enabled')->default(false);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('ga_hash')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('inviter_id')->references('id')->on('users');
        });
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
