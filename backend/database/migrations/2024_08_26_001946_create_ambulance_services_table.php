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
        Schema::create('ambulance_services', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();     
            $table->string('status');                       
            $table->unsignedBigInteger('hospital_id')->nullable(); 
            $table->string('type')->nullable();             
            $table->string('make')->nullable();             
            $table->string('model')->nullable();           
            $table->year('year')->nullable();              
            $table->string('color')->nullable();            
            $table->text('features')->nullable();           
            $table->text('maintenance_record')->nullable(); 
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
        Schema::dropIfExists('ambulance_services');
    }
};
