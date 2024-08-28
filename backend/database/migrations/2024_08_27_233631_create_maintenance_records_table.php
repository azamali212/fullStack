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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ambulance_service_id'); // Foreign key for ambulance services
            $table->date('maintenance_date'); // Date of the maintenance
            $table->string('maintenance_type'); // Type of maintenance (e.g., oil change, tire replacement)
            $table->text('description')->nullable(); // Description of the maintenance work done
            $table->text('actions_taken')->nullable(); // Actions taken during maintenance
            $table->decimal('cost', 8, 2)->nullable(); // Cost of the maintenance
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
        Schema::dropIfExists('maintenance_records');
    }
};
