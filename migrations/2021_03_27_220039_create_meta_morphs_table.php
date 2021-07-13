<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaMorphsTable extends Migration{

    public function up(){
        Schema::create('meta_morphs', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('meta_id');
            $table->text('link');
            $table->text('content');
            $table->timestamps();

            $table->foreign('meta_id')->references('id')->on('metas')->onDelete('cascade')->onUpdate('cascade');
        });
    }


    public function down(){
        Schema::dropIfExists('meta_morphs');
    }
}
