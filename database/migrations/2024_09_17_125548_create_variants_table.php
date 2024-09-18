<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_id');
            $table->string('type'); // 'sauce', 'drink', etc.
            $table->timestamps();

            $table->foreign('food_id')->references('id')->on('food')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
