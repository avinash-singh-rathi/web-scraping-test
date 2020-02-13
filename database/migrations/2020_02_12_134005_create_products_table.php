<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url');
            $table->string('brand');
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->string('pricewithgst')->nullable();
            $table->string('mrp')->nullable();
            $table->string('discount')->nullable();
            $table->string('discounttype')->nullable();
            $table->integer('moq')->nullable();
            $table->integer('poq')->nullable();
            $table->boolean('pricementioned')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
