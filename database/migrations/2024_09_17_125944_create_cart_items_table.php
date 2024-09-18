<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('food_id');
            $table->json('variant_values')->nullable(); // Store multiple variant values
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('food')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
