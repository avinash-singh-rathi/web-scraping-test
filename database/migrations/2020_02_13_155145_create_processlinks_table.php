<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesslinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processlinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->integer('totalitems')->nullable();
            $table->integer('totalpages')->nullable();
            $table->integer('processedpages')->nullable();
            $table->integer('totalitemsperpage')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->enum('status',['completed','processing','pending'])->nullable();
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
        Schema::dropIfExists('processlinks');
    }
}
