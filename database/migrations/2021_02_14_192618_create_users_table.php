<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->required();
            $table->string('password')->required();
            $table->rememberToken()->nullable();
            $table->string('api_token')->nullable();
            $table->string('fatherlastname')->nullable();
            $table->string('motherlastname')->nullable();
            $table->string('email')->required();
            $table->string('affair')->nullable();
            $table->string('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
