<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartsTable extends Migration{

    public function up(){
        Schema::create('charts', function(Blueprint $table){
            $table->id();
            $table->text('chart_name');
            $table->text('table_name');
            $table->string('number');
            $table->string('days');
            $table->string('date_field');
            $table->string('chart_id');
            $table->string('color');
            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('charts');
    }
}
