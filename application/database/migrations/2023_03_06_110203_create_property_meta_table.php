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
        Schema::create('property_meta', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('property_id'); 
			$table->bigInteger('user_id');			
			$table->string('fullname')->nullable();			
			$table->string('floor')->nullable();			
			$table->string('apartment_number')->nullable();			
			$table->string('email')->nullable();			
			$table->string('phone')->nullable();			
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
        Schema::dropIfExists('property_meta');
    }
};
