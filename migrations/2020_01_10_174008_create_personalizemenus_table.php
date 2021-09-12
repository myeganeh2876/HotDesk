<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalizemenusTable extends Migration{

    public function up(){
        Schema::create('personalizemenus', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('personalizemenus');
    }
}
