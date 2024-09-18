<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantValuesTable extends Migration
{
    public function up()
    {
        Schema::create('variant_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_id');
            $table->string('value'); // e.g., 'Tomato Sauce'
            $table->decimal('price', 8, 2); // Additional price for the variant value
            $table->timestamps();

            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_values');
    }
}
