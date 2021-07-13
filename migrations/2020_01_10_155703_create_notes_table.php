<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration{

    public function up(){
        Schema::create('notes', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->longText('content');
            $table->boolean('forall');
            $table->enum('status', ['red', 'green', 'yellow']);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('notes');
    }
}
