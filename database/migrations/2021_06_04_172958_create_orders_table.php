<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->double('price')->nullable();
            $table->bigInteger('quantity');
            $table->double('total_price');
            $table->text('shipping_address');
            $table->foreignId('order_status_id')->constrained('order_statuses')->default(1);
            $table->bigInteger('product_id');
            $table->foreignId('user_id')->constrained("users");
            $table->date('date')->default(now());
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
        Schema::dropIfExists('orders');
    }
}
