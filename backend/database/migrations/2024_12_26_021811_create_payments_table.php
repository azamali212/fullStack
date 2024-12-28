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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_registration_user_id'); // Link to user
            $table->string('transaction_id')->unique(); // Unique transaction ID from payment gateway
            $table->string('payment_method'); // E.g., credit card, PayPal, etc.
            $table->decimal('amount', 10, 2); // Payment amount
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Payment status
            $table->string('payment_gateway')->nullable(); // For storing the payment gateway used (Stripe, PayPal, etc.)
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
        Schema::dropIfExists('payments');
    }
};
