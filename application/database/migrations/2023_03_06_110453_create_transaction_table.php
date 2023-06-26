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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('property_id'); 
			$table->bigInteger('user_id');			
			$table->string('year');			
			$table->string('month');			
			$table->string('price')->nullable();			
			$table->longtext('document')->nullable();			
			$table->longtext('condominium')->nullable();			
			$table->longtext('other')->nullable();	
			$table->integer('type');			
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
        Schema::dropIfExists('transaction');
    }
};
