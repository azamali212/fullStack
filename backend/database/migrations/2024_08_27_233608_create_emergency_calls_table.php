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
        Schema::create('emergency_calls', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->timestamp('call_time'); // Time of the emergency call
            $table->string('location'); // Location of the emergency
            $table->text('details')->nullable(); // Additional details about the emergency
            $table->unsignedBigInteger('patient_id'); // Foreign key to the patients table
            $table->unsignedBigInteger('ambulance_service_id'); // Foreign key to the ambulance_services table
            $table->string('status')->default('pending'); // Status of the call (e.g., pending, dispatched, completed)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_calls');
    }
};
