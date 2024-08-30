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
        Schema::create('ambulance_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age');
            $table->string('degree')->nullable();
            $table->string('license_number')->unique();
            $table->string('phone_number');
            $table->string('address');
            $table->string('profile_image')->nullable();
            $table->unsignedBigInteger('ambulance_service_id')->nullable(); // No constraint
            $table->unsignedBigInteger('hospital_id')->nullable(); // No constraint
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
        Schema::dropIfExists('ambulance_drivers');
    }
};
