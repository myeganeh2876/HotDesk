<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price')->default(0);
            $table->integer('discounted_price')->default(0);
            $table->integer('view')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('sell_num')->default(0);
            $table->integer('sells')->default(0);
            $table->text("main_image")->nullable();
            $table->text("gallery")->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('products');
    }
}
