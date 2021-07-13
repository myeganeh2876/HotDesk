<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration{

    public function up(){
        Schema::create('metas', function(Blueprint $table){
            $table->id();
            $table->text('title')->nullable();
            $table->text('name');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('metas');
    }
}
