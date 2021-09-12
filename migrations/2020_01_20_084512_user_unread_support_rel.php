<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserUnreadSupportRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_unread_support_rel', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('support_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_unread_support_rel');
    }
}
