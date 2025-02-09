<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('token_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('token_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('token_id')->references('id')->on('tokens')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('token_user');
    }
}
