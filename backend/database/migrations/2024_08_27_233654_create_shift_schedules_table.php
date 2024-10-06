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
        Schema::create('shift_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ambulance_driver_id'); // Foreign key for ambulance drivers
            $table->unsignedBigInteger('ambulance_service_id');
            $table->date('shift_date'); // Date of the shift
            $table->time('start_time'); // Start time of the shift
            $table->time('end_time'); // End time of the shift
            $table->string('shift_type')->nullable(); // Type of shift (e.g., day, night)
            $table->text('notes')->nullable(); // Any additional notes or comments
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
        Schema::dropIfExists('shift_schedules');
    }
};
