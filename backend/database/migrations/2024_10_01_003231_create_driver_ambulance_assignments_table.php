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
        Schema::create('driver_ambulance_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambulance_driver_id')->constrained()->onDelete('cascade');
            $table->foreignId('ambulance_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('shift_schedule_id')->constrained()->onDelete('cascade'); // Link to the shift
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
        Schema::dropIfExists('driver_ambulance_assignments');
    }
};
