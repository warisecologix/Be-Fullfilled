<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeInitiatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_initiate_payments', function (Blueprint $table) {
            $table->id();
            $table->text('paymentIntent');
            $table->text('ephemeralKey');
            $table->text('customer');
            $table->string('status')->default('first phase');
            $table->foreignId('user_id')->constrained("users");
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
        Schema::dropIfExists('stripe_initiate_payments');
    }
}
