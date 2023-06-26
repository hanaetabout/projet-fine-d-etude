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
            $table->id();
            $table->bigInteger('role_id');
            $table->string('name');
            $table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->text('tax_address')->nullable();
			$table->string('nif')->nullable();
            $table->timestamp('email_verified_at')->nullable();
			$table->string('avatar')->default('user/default-avatar.png');
            $table->string('password');
            $table->string('normal_password');
            $table->tinyInteger('approve')->default('0');
            $table->text('comment')->nullable();
            $table->string('last_seen')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
};
