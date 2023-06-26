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
        Schema::create('property_gallery', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('property_id'); 
			$table->bigInteger('user_id'); 
			$table->string('media_name'); 
			$table->string('media'); 
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
        Schema::dropIfExists('property_gallery');
    }
};
