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
        Schema::create('hospital_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id'); // Foreign key to hospitals table
            $table->string('name');
            $table->string('profile_image')->nullable();
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('degree')->nullable();
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
        Schema::dropIfExists('hospital_profiles');
    }
};
