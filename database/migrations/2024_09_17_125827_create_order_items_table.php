<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('food_id');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->json('variant_details')->nullable(); // JSON column for storing variant details
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('food')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
