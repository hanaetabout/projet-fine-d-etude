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
        Schema::create('property_owner', function (Blueprint $table) {
            $table->id();
			$table->string('name')->nullable();
			$table->bigInteger('phone')->nullable();
			$table->string('nif')->nullable();
			$table->string('password_at')->nullable();
			$table->string('email')->nullable();
			$table->text('tax_address')->nullable();
			$table->text('comment')->nullable();
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
        Schema::dropIfExists('property_owner');
    }
};
