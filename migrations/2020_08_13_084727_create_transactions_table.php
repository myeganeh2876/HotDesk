<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration{

    public function up(){
        Schema::create('transactions', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('wallet_transaction_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('bank_transaction_id')->nullable();
            $table->string('bank_error_message')->nullable();
            $table->smallInteger('bank_error_code')->nullable();
            $table->string('card_number', 20)->nullable();
            $table->boolean('paid')->default(false);
            $table->timestamps();


            //from base project
            $table->unsignedInteger('client_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->boolean('forsms')->default(false);
            $table->string('from')->default('')->nullable();
            $table->json('transaction_data')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('transaction_date')->nullable();
        });
    }


    public function down(){
        Schema::dropIfExists('transactions');
    }
}
