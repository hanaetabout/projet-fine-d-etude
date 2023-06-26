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
        Schema::create('property', function (Blueprint $table) {
            $table->id();
			$table->text('address');
			$table->bigInteger('owner_id')->nullable();
			$table->bigInteger('user_id');
			$table->string('email_address')->nullable();
			$table->datetime('start_date')->nullable();
			$table->string('nif')->nullable();
			$table->tinyInteger('status')->nullable()->default('0');
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
        Schema::dropIfExists('property');
    }
};
