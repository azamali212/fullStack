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
            $table->string('license_plate')->unique();      // License plate number of the ambulance
            $table->string('status');                       // Status of the ambulance (e.g., available, on duty, maintenance)
            $table->unsignedBigInteger('hospital_id')->nullable(); // Foreign key to the hospitals table
            $table->string('type')->nullable();             // Type of the ambulance (e.g., basic, advanced, specialized)
            $table->string('make')->nullable();             // Make of the ambulance vehicle (e.g., Ford, Mercedes)
            $table->string('model')->nullable();            // Model of the ambulance vehicle
            $table->year('year')->nullable();               // Year the ambulance was manufactured
            $table->string('color')->nullable();            // Color of the ambulance
            $table->text('features')->nullable();           // Features of the ambulance (e.g., life support equipment, oxygen cylinders)
            $table->text('maintenance_record')->nullable(); // Maintenance records or notes
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
