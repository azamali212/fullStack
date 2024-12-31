<?php

namespace App\Http\Controllers\ManagePayment;

use App\Models\Payment;
use App\Models\HospitalRegistrationUser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Http\Controllers\Controller;
use Stripe\Exception\ApiErrorException;

class HospitalRegistrationPaymentController extends Controller
{
    public function __construct()
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    // Endpoint to create a payment intent
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'hospital_registration_user_id' => 'required|exists:hospital_registration_users,id',
            'customer_details' => 'required|array',
        ]);

        $hospitalUser = HospitalRegistrationUser::findOrFail($request->hospital_registration_user_id);

        try {
            // Call Flask API for pricing
            $client = new Client();
            $response = $client->post('http://localhost:5001/generate_pricing');
            $pricingData = json_decode($response->getBody(), true);

            // Use final_price from Flask API
            $amount = $pricingData['final_price'] * 100; // Convert to cents for Stripe

            // Create Stripe PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => 'Hospital Registration Fee for user ID: ' . $hospitalUser->id,
                'metadata' => [
                    'hospital_registration_user_id' => $hospitalUser->id,
                ],
            ]);

            // Save the payment in the database
            $payment = Payment::create([
                'hospital_registration_user_id' => $hospitalUser->id,
                'transaction_id' => $paymentIntent->id,
                'payment_method' => 'card',
                'amount' => $amount / 100, // Convert back to dollars
                'status' => 'pending',
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $payment->id,
                'pricing_details' => $pricingData, // Include Flask pricing details
            ]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // Endpoint to confirm payment (you can call this after the client confirms the payment)
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'payment_intent_id' => 'required|string',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        try {
            // Retrieve the PaymentIntent from Stripe
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status === 'succeeded') {
                // Update payment status to completed
                $payment->status = 'completed';
                $payment->save();
            } else {
                $payment->status = 'failed';
                $payment->save();
            }

            return response()->json([
                'status' => $payment->status,
            ]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
