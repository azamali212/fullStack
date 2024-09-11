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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('registration_number')->unique();
            $table->date('established_date')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->integer('bed_count')->nullable();
            $table->text('specialties')->nullable();
            $table->boolean('emergency_services')->default(false);
            $table->boolean('ambulance_service')->default(false);
            $table->integer('operation_theaters')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('website_url')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->text('accreditations')->nullable();
            $table->text('affiliated_universities')->nullable();
            $table->text('insurance_partners')->nullable();
            $table->string('departments')->nullable();
            $table->string('visiting_hours')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('consultation_fee_range')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            //Images
            $table->string('registration_certificate_image')->nullable();
            $table->string('license_image')->nullable();
            $table->string('fax_id_image')->nullable();
            $table->string('other_documents_image')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('hospitals');
    }
};
